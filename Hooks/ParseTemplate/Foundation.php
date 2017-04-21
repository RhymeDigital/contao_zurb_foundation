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
namespace Rhyme\ContaoZurbFoundationBundle\Hooks\ParseTemplate;

use Contao\Controller;
use Contao\Template;
use Rhyme\ContaoZurbFoundationBundle\Foundation\Parser;

/**
 * Class FoundationParseTemplate 
 *
 * Runs hook for \Contao\Template\parseTemplate
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Foundation extends Controller
{
	/**
	 * Parse the template
	 * @param \Contao\Template
	 * @return \Contao\Template
	 */
	public function run(Template &$objTemplate)
	{
		if(TL_MODE == 'FE')
		{
		    // get the Data of the Template Object
            $arrData = $objTemplate->getData();
            
            //Add foundation classes
		    $strClasses = Parser::getFoundationClasses($arrData);
		    if(!empty($strClasses))
		    {
                $objTemplate->class .= (!empty($objTemplate->class) ? ' ' : '') . $strClasses;
            }
            //Add equalize data attributes
            $strEqualize = Parser::getEqualizeAttributes($arrData);
            if(!empty($strEqualize))
            {
                $objTemplate->cssID .= " $strEqualize";
            }
            
            //Check whether we have orbit slides
            $objTemplate->isOrbitSlide = Parser::checkForOrbitSlides($objTemplate);
        }
        
		return $objTemplate;
	}
  
}
