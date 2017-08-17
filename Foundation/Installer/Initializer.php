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
 * Class Installer
 *
 * Handles installing and upgrading the extension
 * @copyright  2015 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Initializer extends \Controller
{
	
	/**
     * Set the initial theme database values so we avoid string offset errors
     * @return void
     */
    public static function run()
    {
        //Run the default base settings
    	Base::run();

    	//Version 6.4
    	if(version_compare(FOUNDATION, '6.4.0', '>='))
        {
            Foundation_6_4_x::run();
        }

    }

}