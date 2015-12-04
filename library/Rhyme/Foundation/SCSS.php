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
 
 namespace Rhyme\Foundation;
 
 use Leafo\ScssPhp\Compiler;
 
/**
 * Class SCSS
 *
 * Handles compiling the Foundation SCSS
 * @copyright  2015 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class SCSS extends \Controller
{

    /**
     * Confirm that all dependencies are in place
     * @return bool
     */
    public static function confirmDependencies()
    {    
        // !TODO - actually confirm everything and throw Exceptions
        if(!defined('COMPOSER_DIR_RELATIVE')) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Compile the SCSS
     * @param \Contao\ThemeModel
     * @param boolean
     */
    public static function compile(\Contao\ThemeModel $objTheme, $blnForce=false)
    {    
        if(!self::confirmDependencies()) {
            return;
        }
        
        //Get file key
        $strKey = self::getKey($objTheme);
        
        //Set file path
        $strCSSPath = 'assets/foundation/css/' . $strKey . '.css';
        
        //Compile the scss
        if(!file_exists(TL_ROOT . '/' . $strCSSPath) || $blnForce)
        {
            //Gather up the SCSS files in the assets/foundation/scss folder
            //This allows to work with different configs and edit defaults
            //Without affecting the original source
            $strBasePath = COMPOSER_DIR_RELATIVE . '/vendor/zurb/foundation/scss';
            $strCopyPath = 'assets/foundation/scss/' . $strKey;
            
            //Create new folder if not exists and clean it out
            $objNew = new \Folder($strCopyPath);
            $objNew->purge();
            $objOriginal = new \Folder($strBasePath);
            $objOriginal->copyTo($strCopyPath);
                    
            //Apply the config
            self::applyConfig($objTheme, $strCopyPath);
            
            $strFoundationCSS = '';
            $strNormalizeCSS = '';
            
            //Create the SCSS compiler
            if(class_exists('scssc'))
            {
                $objCompiler = new \scssc();
                $objCompiler->setImportPaths(TL_ROOT . '/' . $strCopyPath);
                $objCompiler->setFormatter((\Config::get('debugMode') ? 'scss_formatter' : 'scss_formatter_compressed'));
            }
            else
            {
                $objCompiler = new Compiler();
                $objCompiler->setImportPaths(TL_ROOT . '/' . $strCopyPath);
                $objCompiler->setFormatter((\Config::get('debugMode') ? 'Leafo\ScssPhp\Formatter\Expanded' : 'Leafo\ScssPhp\Formatter\Compressed'));
            }
            
            $strFoundationContent = file_get_contents(TL_ROOT . '/' . $strCopyPath . '/foundation.scss');
            $strNormalizeContent = file_get_contents(TL_ROOT . '/' . $strCopyPath . '/normalize.scss');
            
            //Compile
            $strFoundationCSS   = $objCompiler->compile($strFoundationContent);
            $strNormalizeCSS    = $objCompiler->compile($strNormalizeContent);
            
            //Write to single CSS file cache
            $objFile = new \File($strCSSPath);
            $objFile->write($strNormalizeCSS . "\n" . $strFoundationCSS);
            $objFile->close();
        }
        
        return $strCSSPath; 
    }
    
    /**
     * Get the file key
     * // !TODO - Add a Hook to change the key? This could get complex as we add more features
     * @param \Contao\ThemeModel
     * @return string
     */
    protected static function getKey($objConfig)
    {
        $strKey = '';
        
        //Apply configs
        $arrMediumCustom    = deserialize($objConfig->foundation_break_medium, true);
        $strKey .= 'm-' . ($arrMediumCustom['value'] ?: '') . ($arrMediumCustom['unit'] ?: '');
        $arrLargeCustom     = deserialize($objConfig->foundation_break_large, true);
        $strKey .= 'l-' . ($arrLargeCustom['value'] ?: '') . ($arrLargeCustom['unit'] ?: '');
        $arrXLargeCustom    = deserialize($objConfig->foundation_break_xlarge, true);
        $strKey .= 'xl-' . ($arrXLargeCustom['value'] ?: '') . ($arrXLargeCustom['unit'] ?: '');
        $arrXXLargeCustom   = deserialize($objConfig->foundation_break_xxlarge, true);
        $strKey .= 'xxl-' . ($arrXXLargeCustom['value'] ?: '') . ($arrXXLargeCustom['unit'] ?: '');
        $strKey .= $objConfig->foundation_largegrids;
        
        return $strKey=='m-l-xl-xxl-' ? 'default' : substr(md5($strKey), 0, 12);
    }
    
    /**
     * Handle changing configs in the Foundation SCSS
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function applyConfig($objConfig, $strPath)
    {
        self::includeComponents($objConfig, $strPath);
        self::changeBreakpoints($objConfig, $strPath);
        self::addLargeGrids($objConfig, $strPath);
    }
    
    /**
     * Only include selected Foundation components
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function includeComponents($objConfig, $strPath)
    { 
        $arrAllComponents       = $GLOBALS['FOUNDATION_COMPONENTS'];
        $arrComponentsToInclude = deserialize($objConfig->foundation_components);
        
        $objFile = new \File($strPath . '/foundation.scss');
        $strContent = $objFile->getContent();
        $strFormat = "@import 'foundation/components/%s';";
        
        //Loop through all components to make sure we only include ones we want
        foreach($arrAllComponents as $component)
        {
            $strInclude = sprintf($strFormat, $component);
            
            if(in_array($component, $arrComponentsToInclude))
            {
                if(stripos($strContent, $strInclude) === false)
                {
                    //Include if not there
                    $strContent .= "\n" . $strInclude;
                }
            }
            else 
            {
                //Remove
                $strContent = str_replace($strInclude, '', $strContent);
            }
        }
        
        //Clean up blank lines
        $strContent = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $strContent);
        $objFile->write($strContent);
        $objFile->close();
    }
    
    /**
     * Change the Foundation breakpoints
     * // !TODO - simplify this with another method, and also use custom base font size when that gets implemented
     * // !TODO - Eliminate the unit option since Zurb seems to have moved to a pixel-based setup as of 5.5.2
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function changeBreakpoints($objConfig, $strPath)
    {       
        \System::loadLanguageFile('foundation');
            
        $arrRanges = $GLOBALS['TL_LANG']['FOUNDATION']['SCSS']['BREAKPOINT'];
        
        $arrMediumCustom    = deserialize($objConfig->foundation_break_medium);
        $arrLargeCustom     = deserialize($objConfig->foundation_break_large);
        $arrXLargeCustom    = deserialize($objConfig->foundation_break_xlarge);
        $arrXXLargeCustom   = deserialize($objConfig->foundation_break_xxlarge);
        
        $objFile = new \File($strPath . '/foundation/components/_global.scss');
        $strContent = $objFile->getContent();
        
        if(!empty($arrMediumCustom['value']))
        {
            $intSmallRange      = $arrRanges['small'];
            //Note double space after definition!
            $strSmallReplace    = '$small-breakpoint:  em-calc('.$intSmallRange.')';
            $strSmallNew        = '$small-breakpoint:  em-calc('.$arrMediumCustom['value'].')';
            $strContent = str_replace($strSmallReplace, $strSmallNew, $strContent);
        }
        if(!empty($arrLargeCustom['value']))
        {
            $intMediumRange     = $arrRanges['medium'];
            //Note single space after definition!
            $strMediumReplace   = '$medium-breakpoint: em-calc('.$intMediumRange.')';
            $strMediumNew       = '$medium-breakpoint: em-calc('.$arrLargeCustom['value'].')';
            $strContent = str_replace($strMediumReplace, $strMediumNew, $strContent);
        }
        if(!empty($arrXLargeCustom['value']))
        {
            $intLargeRange      = $arrRanges['large'];
            //Note double space after definition!
            $strLargeReplace    = '$large-breakpoint:  em-calc('.$intLargeRange.')';
            $strLargeNew        = '$large-breakpoint:  em-calc('.$arrXLargeCustom['value'].')';
            $strContent = str_replace($strLargeReplace, $strLargeNew, $strContent);
        }
        if(!empty($arrXXLargeCustom['value']))
        {
            $intXLargeRange     = $arrRanges['xlarge'];
            //Note single space after definition!
            $strXLargeReplace   = '$xlarge-breakpoint: em-calc('.$intXLargeRange.')';
            $strXLargeNew       = '$xlarge-breakpoint: em-calc('.$arrXXLargeCustom['value'].')';
            $strContent = str_replace($strXLargeReplace, $strXLargeNew, $strContent);
        }
        
        $objFile->write($strContent);
        $objFile->close();
    }
    
    /**
     * Decide whether to add in the Foundation large grid classes
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function addLargeGrids($objConfig, $strPath)
    { 
        if($objConfig->foundation_largegrids)
        {
            $objFile = new \File($strPath . '/foundation/components/_grid.scss');
            $strContent = $objFile->getContent();
            
            $strContent = str_replace('include-xl-html-grid-classes: false', 'include-xl-html-grid-classes: true', $strContent);
            
            $objFile->write($strContent);
            $objFile->close();
        }
    }
    
}
