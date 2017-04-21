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


//Purge the Foundation cache
\Rhyme\ContaoZurbFoundationBundle\Foundation\Automator::purgeFoundationCache();

//Run the installer/upgrader
\Rhyme\ContaoZurbFoundationBundle\Foundation\Installer::install();

