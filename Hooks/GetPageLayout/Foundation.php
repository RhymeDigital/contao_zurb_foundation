<?php

/**
 * Zurb Foundation integration for Contao Open Source CMS
 *
 * Copyright (C) 2017 Rhyme Digital
 *
 * @package    Zurb_Foundation
 * @link       http://rhyme.digital
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */
 

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Rhyme\ContaoZurbFoundationBundle\Hooks\GetPageLayout;

use Contao\Config;
use Contao\Combiner;
use Contao\Controller;
use Contao\PageModel;
use Contao\LayoutModel;
use Contao\ThemeModel;
use Contao\PageRegular;
use Rhyme\ContaoZurbFoundationBundle\Foundation\SCSS;


/**
 * Class FoundationGetPageLayout 
 *
 * Runs hook for \Contao\PageRegular\parseTemplate
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Foundation extends Controller
{
	/**
	 * Modify the page or layout object - Add in Foundation JS and CSS first!
	 * @param \Contao\PageModel
	 * @param \Contao\LayoutModel
     * @param \Contao\PageRegular
	 * @return void
	 */
	public function run(PageModel $objPage, LayoutModel &$objLayout, PageRegular $objPageRegular)
	{

        if(!empty($GLOBALS['FOUNDATION_JS']))
        {
            //Check for Debug Mode
            if (Config::get('debugMode')) {
                $arrStaticScripts = array();
                foreach ($GLOBALS['FOUNDATION_JS'] as $script) {
                    $arrStaticScripts[] = str_replace('.min', '', $script) . '|static';
                }

                array_insert($GLOBALS['TL_JAVASCRIPT'], 0, $arrStaticScripts);
            } else {
                //Load up our Required Foundation JS into a Combiner
                $objCombiner = new Combiner();

                foreach ($GLOBALS['FOUNDATION_JS'] as $strFile) {
                    $objCombiner->add($strFile);
                }

                array_insert($GLOBALS['TL_JAVASCRIPT'], 0, array
                (
                    $objCombiner->getCombinedFile() . "|static"
                ));
            }
        }
        
		//Load in Foundation CSS by Theme
        /** @var ThemeModel $objTheme */
        $objTheme = $objLayout->getRelated('pid');

		array_insert($GLOBALS['TL_CSS'], 0, array
        (
        	SCSS::compile($objTheme) . "|screen|static"
        ));
        
        $objLayout->script .= "\n" . "<script>(function($) { $(document).foundation(); })(jQuery);</script>";

	}
}
