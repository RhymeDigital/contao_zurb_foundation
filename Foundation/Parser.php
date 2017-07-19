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
namespace Rhyme\ContaoZurbFoundationBundle\Foundation;

use Contao\Controller;
use Contao\Database;
use Contao\Template;
use Contao\Widget;

/**
 * Class FoundationParser
 *
 * Contains methods for parsing data arrays (DCAs mostly) to return Foundation attributes
 * @copyright  2015 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class Parser extends Controller
{
	
	/**
	 * Add foundation classes
	 * @param array
	 * @return string
	 */
	public static function getFoundationClasses($arrData)
	{
	    $arrFoundationClasses = array_merge(static::getVisibilityClasses($arrData),
	                                        static::getBlockGridClasses($arrData),
	                                        static::getGridClasses($arrData));
	    
	    return implode(' ', $arrFoundationClasses);
	}
	
	/**
	 * Add foundation classes
	 * @param array
	 * @return string
	 */
	public static function getEqualizeAttributes($arrData)
	{
	    $arrEqualizeAttributes = array();
	    
	    if(!empty($arrData['foundation_equalizer'])) {
    	    $arrEqualizeAttributes[] = 'data-equalizer';
	    }
	    if(!empty($arrData['foundation_equalize'])) {
    	    $arrEqualizeAttributes[] = 'data-equalizer-watch';
	    }
	    
	    return implode(' ', $arrEqualizeAttributes);
	}
	
	/**
	 * Add visibility settings
	 * @param array
	 * @return array
	 */
	public static function getVisibilityClasses($arrData)
	{
	    $arrVisibilityClasses = array();
	    
	    //Parse Foundation Visibility Class
		if($arrData['foundation_visibility'])
		{
		    if(!empty($arrData['foundation_visibility_show'])){
    		  $arrVisibilityClasses[] = $arrData['foundation_visibility_show'];
		    }
		    if(!empty($arrData['foundation_visibility_hide'])){
    		  $arrVisibilityClasses[] = $arrData['foundation_visibility_hide'];
		    }
		    if(!empty($arrData['foundation_visibility_orientation'])){
    		  $arrVisibilityClasses[] = $arrData['foundation_visibility_orientation'];
		    }
		    if(!empty($arrData['foundation_visibility_touch'])){
    		  $arrVisibilityClasses[] = $arrData['foundation_visibility_touch'];
		    }
		}
        
        return $arrVisibilityClasses;
	}
	
	/**
	 * Add block grid class settings
	 * @param array
	 * @return array
	 */
	public static function getBlockGridClasses($arrData)
	{
	    $arrBlockGridClasses = array();
	    
	    if($arrData['foundation_block_grid'])
		{
    		$arrBlockSettings = deserialize($arrData['foundation_block_grid_settings']);
    				
    		//Block grid settings
    		foreach($arrBlockSettings[0] as $size => $intCols)
    		{
        		if(!empty($intCols)) {
            		$arrBlockGridClasses[] = $size . '-block-grid-' . $intCols;
        		}
    		}
        }
		
		return $arrBlockGridClasses;
	}
	
	/**
	 * Add grid class settings
	 * @param array
	 * @return string
	 */
	public static function getGridClasses($arrData)
	{
	    $arrGridClasses = array();
	    
	    if($arrData['foundation_grid'])
		{
    		$arrSmallSettings = deserialize($arrData['foundation_grid_small']);
    		$arrMediumSettings = deserialize($arrData['foundation_grid_medium']);
    		$arrLargeSettings = deserialize($arrData['foundation_grid_large']);
    		$arrXLargeSettings = deserialize($arrData['foundation_grid_xlarge']);
    		$arrXXLargeSettings = deserialize($arrData['foundation_grid_xxlarge']);
    				
    		//Small settings
    		$arrGridClasses = array_merge(static::parseGridSettings('small', $arrSmallSettings[0]), 
    		                              static::parseGridSettings('medium', $arrMediumSettings[0]),
    		                              static::parseGridSettings('large', $arrLargeSettings[0]),
    		                              static::parseGridSettings('xlarge', $arrXLargeSettings[0]),
    		                              static::parseGridSettings('xxlarge', $arrXXLargeSettings[0]));
        
        }
        
        //Collapse settings on row - Foundation 5.5.0+ Only
        if($arrData['foundation_collapse'])
        {
            $arrCollapseSettings = deserialize($arrData['foundation_grid_collapse']);
            foreach($arrCollapseSettings[0] as $size => $strCollapse)
    		{
        		if(!empty($strCollapse)) {
            		$arrGridClasses[] = $size . '-' . $strCollapse;
        		}
    		}
        }
        
		return array_unique($arrGridClasses);
	}
	
	/**
	 * Parse grid class settings - Parse Foundation Columns/Offset/Push/Pull/End
	 * @param string
	 * @param array
	 * @return array
	 */
    public static function parseGridSettings($strSize='small', $arrSettings=array())
    {
        $arrParsedGridClasses = array();
        
        if(!empty($arrSettings['columns'])) {
            $arrParsedGridClasses[] = $strSize . '-' . $arrSettings['columns'];
            $arrParsedGridClasses[] = 'column';
        }
        if(!empty($arrSettings['offset'])) {
            $arrParsedGridClasses[] = $strSize . '-offset-' . $arrSettings['offset'];
        }
        if(!empty($arrSettings['push'])) {
            $arrParsedGridClasses[] = $strSize . '-push-' . $arrSettings['push'];
        }
        if(!empty($arrSettings['pull'])) {
            $arrParsedGridClasses[] = $strSize . '-pull-' . $arrSettings['pull'];
        }
        if(!empty($arrSettings['centering'])) {
            $arrParsedGridClasses[] = $strSize . '-' . $arrSettings['centering'];
        }
        if(!empty($arrSettings['end'])) {
            $arrParsedGridClasses[] = 'end';
        }
        
        return $arrParsedGridClasses;
    }
    
    /**
	 * Check if this template should be designated as an Orbit Slide
	 * @param \Contao\Template
	 * @return boolean
	 */
	public static function checkForOrbitSlides(Template $objTemplate)
    {
    	$blnIsOrbitSlide = false;

    	//Check for content element
    	if(substr($objTemplate->getName(), 0, 3) == 'ce_')
    	{
	    	$arrCheck = Database::getInstance()->prepare("SELECT sorting, type FROM tl_content
	    												   WHERE pid=? AND ptable=?
	    												   AND (type='foundation_orbitstart' 
	    												   OR type='foundation_orbitstop')
	    												   ORDER BY sorting ASC")
	    												   ->execute($objTemplate->pid, $objTemplate->ptable)
	    												   ->fetchAllAssoc();
	    												   
	    	if(!empty($arrCheck))
	    	{
	    		for($i=0; $i < count($arrCheck); $i++)
	    		{
	    			$intNext = $i < count($arrCheck) ? $i+1 : $i;
		    		if( $arrCheck[$i]['type']=='foundation_orbitstart' && 
		    			$arrCheck[$intNext]['type']=='foundation_orbitstop' &&
		    			$arrCheck[$i]['sorting'] < $objTemplate->sorting &&
		    			$arrCheck[$intNext]['sorting'] > $objTemplate->sorting )
		    		{
			    		$blnIsOrbitSlide = true;
		    		}
	    		}
	    	}
    	}
    	
    	return $blnIsOrbitSlide;
    }
	
	/**
	 * Extract foundation data from Widgets
	 * @param \Contao\Widget
	 * @return array
	 */
	public static function getFoundationAttributesFromWidget(Widget $objWidget)
	{
	    $arrData = array();
	    foreach($GLOBALS['TL_DCA']['tl_form_field']['fields'] as $field => $data)
	    {
    	    if(substr($field, 0, 11)=='foundation_')
    	    {
        	    $arrData[$field] = $objWidget->{$field};
    	    }
	    }
	    
	    return $arrData;
	}
	
}
