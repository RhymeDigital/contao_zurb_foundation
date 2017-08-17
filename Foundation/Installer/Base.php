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
class Base extends \Controller
{

    /**
     * Set the initial theme database values so we avoid string offset errors
     * @return void
     */
    public static function run()
    {
        $arrSet = array('value'=> '', 'unit'=> '');
        $objDB = \Database::getInstance();

        if(!$objDB->fieldExists('foundation_break_medium', 'tl_theme'))
        {
            $objDB->query("ALTER TABLE tl_theme ADD foundation_break_medium varchar(64) NOT NULL default ''");
        }
        if(!$objDB->fieldExists('foundation_break_large', 'tl_theme'))
        {
            $objDB->query("ALTER TABLE tl_theme ADD foundation_break_large varchar(64) NOT NULL default ''");
        }
        if(!$objDB->fieldExists('foundation_break_xlarge', 'tl_theme'))
        {
            $objDB->query("ALTER TABLE tl_theme ADD foundation_break_xlarge varchar(64) NOT NULL default ''");
        }
        if(!$objDB->fieldExists('foundation_break_xxlarge', 'tl_theme'))
        {
            $objDB->query("ALTER TABLE tl_theme ADD foundation_break_xxlarge varchar(64) NOT NULL default ''");
        }
        if(!$objDB->fieldExists('foundation_components', 'tl_theme'))
        {
            $objDB->query("ALTER TABLE tl_theme ADD foundation_components blob NULL");
        }

        $arrMSet = array('foundation_break_medium' => $arrSet);
        $objDB->prepare("UPDATE tl_theme %s WHERE !(foundation_break_medium > '')")
            ->set($arrMSet)
            ->execute();

        $arrLSet = array('foundation_break_large' => $arrSet);
        $objDB->prepare("UPDATE tl_theme %s WHERE !(foundation_break_large > '')")
            ->set($arrLSet)
            ->execute();

        $arrXLSet = array('foundation_break_xlarge' => $arrSet);
        $objDB->prepare("UPDATE tl_theme %s WHERE !(foundation_break_xlarge > '')")
            ->set($arrXLSet)
            ->execute();

        $arrXXLSet = array('foundation_break_xxlarge' => $arrSet);
        $objDB->prepare("UPDATE tl_theme %s WHERE !(foundation_break_xxlarge > '')")
            ->set($arrXXLSet)
            ->execute();

        $arrComponents = array('foundation_components' => $GLOBALS['FOUNDATION_COMPONENTS']);
        $objDB->prepare("UPDATE tl_theme %s WHERE foundation_components IS NULL")
            ->set($arrComponents)
            ->execute();

    }

}