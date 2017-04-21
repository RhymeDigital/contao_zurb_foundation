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
namespace Rhyme\ContaoZurbFoundationBundle\Hooks\LoadFormField;

use Contao\Form;
use Contao\Widget;
use Contao\Controller;
use Rhyme\ContaoZurbFoundationBundle\Foundation\Parser;

/**
 * Class FoundationLoadFormField
 *
 * Runs hook for \Contao\Form\LoadFormField
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Foundation extends Controller
{
	/**
	 * Modify a generated widget
	 * @param \Contao\Widget
	 * @param string
	 * @param array
	 * @param \Contao\Form
	 * @return \Contao\Widget
	 */
	public function run(Widget $objWidget, $formId, $arrFormData, Form $objForm)
	{
        if(TL_MODE == 'FE')
		{
		    // get the Data of the Widget Object
            $arrData = Parser::getFoundationAttributesFromWidget($objWidget);
            
            //Add foundation classes
		    $strClasses = Parser::getFoundationClasses($arrData);
		    if(!empty($strClasses))
		    {
                $objWidget->class .= (!empty($objWidget->class) ? ' ' : '') . $strClasses;
            }
            //Add equalize data attributes
            $strEqualize = Parser::getEqualizeAttributes($arrData);
            if(!empty($strEqualize))
            {
                $objWidget->cssID .= " $strEqualize";
            }
        }
        
        return $objWidget;
	}
}
