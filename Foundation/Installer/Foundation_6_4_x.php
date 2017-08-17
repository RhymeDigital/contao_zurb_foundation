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

namespace Rhyme\ContaoZurbFoundationBundle\Foundation\Installer;

/**
 * Class Default
 *
 * Handles installing and upgrading the extension
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Foundation_6_4_x extends \Controller
{

    /**
     * Set the initial theme database values so we avoid string offset errors
     * @return void
     */
    public static function run()
    {
        //Need to update all visibility settings
        self::updateVisibilitySettings('tl_content');
        self::updateVisibilitySettings('tl_module');
        self::updateVisibilitySettings('tl_form_field');
    }


    /**
     * Update settings by table
     * @param $strTable
     */
    public static function updateVisibilitySettings($strTable)
    {

        $dbResult = \Database::getInstance()->execute("SELECT 
                                                                  id,
                                                                  foundation_visibility_show,
                                                                  foundation_visibility_hide
                                                                  FROM $strTable");

        while($dbResult->next())
        {
            $arrSet = array
            (
                'foundation_visibility_show' => str_replace('-up', '', $dbResult->foundation_visibility_show),
                'foundation_visibility_hide' => str_replace('-up', '', $dbResult->foundation_visibility_hide),
            );

            \Database::getInstance()->prepare("UPDATE $strTable %s WHERE id=?")->set($arrSet)->execute($dbResult->id);
        }
    }

}