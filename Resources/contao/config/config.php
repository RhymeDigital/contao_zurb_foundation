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
 * Foundation version
 */
define('FOUNDATION', '6.3.1');
 

/**
 * Content Elements
 */

$GLOBALS['TL_CTE']['foundation'] = array(
	'foundation_sidenav'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\SideNav',
	'foundation_rowstart'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\RowStart',
	'foundation_rowstop'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\RowStop',
	'foundation_genericstart'				=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\GenericStart',
	'foundation_genericstop'				=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\GenericStop',
	'foundation_orbitstart'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\OrbitStart',
	'foundation_orbitstop'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\OrbitStop',
	'foundation_flexvideo'					=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\FlexVideo',
	'foundation_interchangesingle'			=> 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\InterchangeImageSingle',
	'foundation_revealmodalwindow'          => 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\RevealModalWindow',
    'foundation_tabs'	                    => 'Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation\Tabs',
);

/**
 * Frontend Modules
 */

array_insert($GLOBALS['FE_MOD']['application'], 4, array
(
	'foundation_offcanvas' => '\Rhyme\ContaoZurbFoundationBundle\Module\Foundation\OffCanvas'
));

array_insert($GLOBALS['FE_MOD']['application'], 5, array
(
	'foundation_revealmodalwindow' => '\Rhyme\ContaoZurbFoundationBundle\Module\Foundation\RevealModalWindow'
));

array_insert($GLOBALS['FE_MOD']['navigationMenu'], 8, array
(
	'foundationnav_topbar' => '\Rhyme\ContaoZurbFoundationBundle\Module\Foundation\NavTopBar',
	'foundation_tabbar' => '\Rhyme\ContaoZurbFoundationBundle\Module\Foundation\TabBar',
	'foundation_iconbar'    => '\Rhyme\ContaoZurbFoundationBundle\Module\Foundation\IconBar',
));



/**
 * Form fields
 */
array_insert($GLOBALS['TL_FFL'], 20, array
(
	'foundation_rowstart'           => 'Rhyme\ContaoZurbFoundationBundle\FormField\Foundation\RowStart',
	'foundation_rowstop'			=> 'Rhyme\ContaoZurbFoundationBundle\FormField\Foundation\RowStop',
	'foundation_genericstart'		=> 'Rhyme\ContaoZurbFoundationBundle\FormField\Foundation\GenericStart',
	'foundation_genericstop'		=> 'Rhyme\ContaoZurbFoundationBundle\FormField\Foundation\GenericStop',
));

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate'][] 		= array('Rhyme\ContaoZurbFoundationBundle\Hooks\ParseTemplate\Foundation', 'run');
$GLOBALS['TL_HOOKS']['loadFormField'][]         = array('Rhyme\ContaoZurbFoundationBundle\Hooks\LoadFormField\Foundation', 'run');
$GLOBALS['TL_HOOKS']['getPageLayout'][] 		= array('Rhyme\ContaoZurbFoundationBundle\Hooks\GetPageLayout\Foundation', 'run');
$GLOBALS['TL_HOOKS']['getCombinedFile'][] 		= array('Rhyme\ContaoZurbFoundationBundle\Hooks\GetCombinedFile\Foundation', 'run');
//$GLOBALS['TL_HOOKS']['getAttributesFromDca'][]  = array('Rhyme\ContaoZurbFoundationBundle\Hooks\StoreTabTitles\Foundation', 'run');


/**
 * Wrappers for Elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] 	= 'foundation_rowstart';
$GLOBALS['TL_WRAPPERS']['start'][] 	= 'foundation_genericstart';
$GLOBALS['TL_WRAPPERS']['start'][] 	= 'foundation_orbitstart';
$GLOBALS['TL_WRAPPERS']['stop'][] 	= 'foundation_rowstop';
$GLOBALS['TL_WRAPPERS']['stop'][] 	= 'foundation_genericstop';
$GLOBALS['TL_WRAPPERS']['stop'][] 	= 'foundation_orbitstop';

/**
 * Backend styles
 */
if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS']['foundation'] = $GLOBALS['TL_CONFIG']['debugMode']
            ? 'system/modules/zurb_foundation/assets/be_style.src.css'
            : 'system/modules/zurb_foundation/assets/be_style.css';
}

/**
 * Foundation JS array for combiner
 */
$GLOBALS['FOUNDATION_JS'] = array
(
	'modernizr'					=> 'vendor/components/modernizr/modernizr.js',
	'jquerymin'					=> 'vendor/components/jquery/jquery.min.js',
	'foundation'				=> 'vendor/zurb/foundation/js/foundation/foundation.core.js',
    'foundation-util-box'		=> 'vendor/zurb/foundation/js/foundation/foundation.util.box.js',
    'foundation-util-keyboard'	=> 'vendor/zurb/foundation/js/foundation/foundation.util.keyboard.js',
    'foundation-util-mediaQuery'=> 'vendor/zurb/foundation/js/foundation/foundation.util.mediaQuery.js',
    'foundation-util-motion'	=> 'vendor/zurb/foundation/js/foundation/foundation.util.motion.js',
    'foundation-util-nest'		=> 'vendor/zurb/foundation/js/foundation/foundation.util.nest.js',
    'foundation-util-timer'		=> 'vendor/zurb/foundation/js/foundation/foundation.util.timerAndImageLoader.js',
    'foundation-util-touch'		=> 'vendor/zurb/foundation/js/foundation/foundation.util.touch.js',
    'foundation-util-triggers'	=> 'vendor/zurb/foundation/js/foundation/foundation.util.triggers.js',
	'foundation-abide'			=> 'vendor/zurb/foundation/js/foundation/foundation.abide.js',
	'foundation-accordion'		=> 'vendor/zurb/foundation/js/foundation/foundation.accordion.js',
    'foundation-accordionmenu'	=> 'vendor/zurb/foundation/js/foundation/foundation.accordionMenu.js',
	'foundation-dropdown'		=> 'vendor/zurb/foundation/js/foundation/foundation.dropdown.js',
    'foundation-dropdown-menu'	=> 'vendor/zurb/foundation/js/foundation/foundation.dropdownMenu.js',
	'foundation-equalizer'		=> 'vendor/zurb/foundation/js/foundation/foundation.equalizer.js',
	'foundation-interchange'	=> 'vendor/zurb/foundation/js/foundation/foundation.interchange.js',
	'foundation-magellan'		=> 'vendor/zurb/foundation/js/foundation/foundation.magellan.js',
	'foundation-offcanvas'		=> 'vendor/zurb/foundation/js/foundation/foundation.offcanvas.js',
	'foundation-orbit'			=> 'vendor/zurb/foundation/js/foundation/foundation.orbit.js',
    'foundation-responsivemenu' => 'vendor/zurb/foundation/js/foundation/foundation.responsiveMenu.js',
    'foundation-responsivetoggle'=> 'vendor/zurb/foundation/js/foundation/foundation.responsiveToggle.js',
	'foundation-reveal'			=> 'vendor/zurb/foundation/js/foundation/foundation.reveal.js',
	'foundation-slider'			=> 'vendor/zurb/foundation/js/foundation/foundation.slider.js',
    'foundation-sticky'			=> 'vendor/zurb/foundation/js/foundation/foundation.sticky.js',
	'foundation-tabs'			=> 'vendor/zurb/foundation/js/foundation/foundation.tabs.js',
	'foundation-toggler'		=> 'vendor/zurb/foundation/js/foundation/foundation.toggler.js',
	'foundation-tooltip'		=> 'vendor/zurb/foundation/js/foundation/foundation.tooltip.js',
);

/**
 * Foundation Components array for combiner
 */
$GLOBALS['FOUNDATION_COMPONENTS'] = array
(
	'abide',
    'accordion',
    'accordion-menu',
    'badge',
    'breadcrumbs',
	'button-groups',
	'buttons',
	'callout',
	'card',
	'close-button',
	'drilldown',
	'dropdown',
    'dropdown-menu',
	'equalizer',
	'flex',
	'flex-video',
    'flex-grid',
    'float',
	'forms',
	'grid',
	'interchange',
	'joyride',
	'keystrokes',
	'labels',
	'magellan',
    'media-object',
    'menu',
    'menu-icon',
	'motion-ui',
	'offcanvas',
	'orbit',
	'pagination',
	'progress-bars',
	'responsive-embed',
	'reveal',
	'slider',
	'sticky',
	'switches',
	'tables',
	'tabs',
    'title-bar',
	'thumbs',
	'toggler',
	'tooltips',
	'top-bar',
	'type',
	'visibility',
);


/**
 * Purge jobs
 */
array_insert($GLOBALS['TL_PURGE']['folders'], 4, array
(
	'foundation' => array
	(
	    'callback' => array('Rhyme\ContaoZurbFoundationBundle\Foundation\Automator', 'purgeFoundationCache'),
        'affected' => array('assets/foundation'),
    )
));

