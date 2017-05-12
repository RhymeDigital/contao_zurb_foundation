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
	'foundation'				=> 'vendor/zurb/foundation/js/foundation.core.js',
    'foundation-util-box'		=> 'vendor/zurb/foundation/js/foundation.util.box.js',
    'foundation-util-keyboard'	=> 'vendor/zurb/foundation/js/foundation.util.keyboard.js',
    'foundation-util-mediaQuery'=> 'vendor/zurb/foundation/js/foundation.util.mediaQuery.js',
    'foundation-util-motion'	=> 'vendor/zurb/foundation/js/foundation.util.motion.js',
    'foundation-util-nest'		=> 'vendor/zurb/foundation/js/foundation.util.nest.js',
    'foundation-util-timer'		=> 'vendor/zurb/foundation/js/foundation.util.timerAndImageLoader.js',
    'foundation-util-touch'		=> 'vendor/zurb/foundation/js/foundation.util.touch.js',
    'foundation-util-triggers'	=> 'vendor/zurb/foundation/js/foundation.util.triggers.js',
    'foundation-zfaccordiontabs'=> 'vendor/zurb/foundation/js/foundation.zf.responsiveAccordionTabs.js',
	'foundation-abide'			=> 'vendor/zurb/foundation/js/foundation.abide.js',
	'foundation-accordion'		=> 'vendor/zurb/foundation/js/foundation.accordion.js',
    'foundation-accordionmenu'	=> 'vendor/zurb/foundation/js/foundation.accordionMenu.js',
    'foundation-drilldown'		=> 'vendor/zurb/foundation/js/foundation.drilldown.js',
    'foundation-dropdown'		=> 'vendor/zurb/foundation/js/foundation.dropdown.js',
    'foundation-dropdown-menu'	=> 'vendor/zurb/foundation/js/foundation.dropdownMenu.js',
	'foundation-equalizer'		=> 'vendor/zurb/foundation/js/foundation.equalizer.js',
	'foundation-interchange'	=> 'vendor/zurb/foundation/js/foundation.interchange.js',
	'foundation-magellan'		=> 'vendor/zurb/foundation/js/foundation.magellan.js',
	'foundation-offcanvas'		=> 'vendor/zurb/foundation/js/foundation.offcanvas.js',
	'foundation-orbit'			=> 'vendor/zurb/foundation/js/foundation.orbit.js',
    'foundation-responsivemenu' => 'vendor/zurb/foundation/js/foundation.responsiveMenu.js',
    'foundation-responsivetoggle'=> 'vendor/zurb/foundation/js/foundation.responsiveToggle.js',
	'foundation-reveal'			=> 'vendor/zurb/foundation/js/foundation.reveal.js',
	'foundation-slider'			=> 'vendor/zurb/foundation/js/foundation.slider.js',
    'foundation-sticky'			=> 'vendor/zurb/foundation/js/foundation.sticky.js',
	'foundation-tabs'			=> 'vendor/zurb/foundation/js/foundation.tabs.js',
	'foundation-toggler'		=> 'vendor/zurb/foundation/js/foundation.toggler.js',
	'foundation-tooltip'		=> 'vendor/zurb/foundation/js/foundation.tooltip.js',
);

/**
 * Foundation Components array for combiner
 */
$GLOBALS['FOUNDATION_COMPONENTS'] = array
(
    'grid/grid',
    'typography/typography',
    'forms/forms',
    'components/visibility',
    'components/float',
    'components/button',
    'components/button-group',
    'components/accordion-menu',
    'components/accordion',
    'components/badge',
    'components/breadcrumbs',
    'components/callout',
    'components/card',
    'components/close-button',
    'components/drilldown',
    'components/dropdown-menu',
    'components/dropdown',
    'components/flex',
    'components/responsive-embed',
    'components/label',
    'components/media-object',
    'components/menu',
    'components/menu-icon',
    'components/off-canvas',
    'components/orbit',
    'components/pagination',
    'components/progress-bar',
    'components/reveal',
    'components/slider',
    'components/sticky',
    'components/switch',
    'components/table',
    'components/tabs',
    'components/title-bar',
    'components/top-bar',
    'components/thumbnail',
    'components/tooltip',
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

