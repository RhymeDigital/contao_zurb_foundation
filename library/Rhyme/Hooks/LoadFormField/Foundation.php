<?php

/**
 * Zurb Foundation integration for Contao Open Source CMS
 *
 * Copyright (C) 2015 Rhyme Digital
 *
 * @package    Zurb_Foundation
 * @link       http://rhyme.digital
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */
 

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Rhyme\Hooks\LoadFormField;

use Rhyme\Foundation\Parser;

/**
 * Class FoundationLoadFormField
 *
 * Runs hook for \Contao\Form\LoadFormField
 * @copyright  2015 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Foundation extends \Controller
{
	/**
	 * Modify a generated widget
	 * @param Contao/Widget $objWidget
	 * @param string $formId
	 * @param array $arrFormData
	 * @param Contao/Form $objForm
	 * @return void
	 */
	public function run($objWidget, $formId, $arrFormData, $objForm)
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
