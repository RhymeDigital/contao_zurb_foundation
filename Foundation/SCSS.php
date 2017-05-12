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
 
namespace Rhyme\ContaoZurbFoundationBundle\Foundation;

use Contao\File;
use Contao\Config;
use Contao\Controller;
use Contao\ThemeModel;
use Leafo\ScssPhp\Compiler;
 
/**
 * Class SCSS
 *
 * Handles compiling the Foundation SCSS
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class SCSS extends Controller
{

    /**
     * Confirm that all dependencies are in place
     * @return bool
     */
    public static function confirmDependencies()
    {
        $dependenciesInstalled = true;
        if(!is_dir(TL_ROOT . '/vendor/zurb/foundation') ||
            !is_dir(TL_ROOT . '/vendor/components/jquery') ||
            !is_dir(TL_ROOT . '/vendor/components/modernizr') )
        {
            $dependenciesInstalled = false;
        }

        return $dependenciesInstalled;
    }


    /**
     * Compile the SCSS
     * @param \Contao\ThemeModel
     * @param boolean
     * @return string
     */
    public static function compile(ThemeModel $objTheme, $blnForce=false)
    {    
        if(!self::confirmDependencies()) {
            throw new \RuntimeException('Please run composer install... you are missing dependencies for the Contao Foundation bundle.');
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
            $strBasePath = 'vendor/zurb/foundation/scss';
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
                $objCompiler->setFormatter((Config::get('debugMode') ? 'Leafo\ScssPhp\Formatter\Expanded' : 'Leafo\ScssPhp\Formatter\Compressed'));
            }
            
            $strFoundationContent = file_get_contents(TL_ROOT . '/' . $strCopyPath . '/foundation.scss');

            //Compile
            $strFoundationCSS   = $objCompiler->compile($strFoundationContent);

            //Write to single CSS file cache
            $objFile = new File($strCSSPath);
            $objFile->write($strFoundationCSS);
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
    protected static function getKey(ThemeModel $objConfig)
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
    protected static function applyConfig(ThemeModel $objConfig, $strPath)
    {
        self::includeComponents($objConfig, $strPath);
        self::changeBreakpoints($objConfig, $strPath);
    }
    
    /**
     * Only include selected Foundation components
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function includeComponents(ThemeModel $objConfig, $strPath)
    { 
        $arrAllComponents       = $GLOBALS['FOUNDATION_COMPONENTS'];
        $arrComponentsToInclude = deserialize($objConfig->foundation_components, true);
        
        $objFile = new File($strPath . '/foundation.scss');

        $strImportFormat = "@import '%s';";
        $strIncludeFormat = "@include foundation-%s;";
        $blnFlexGrid = false;

        $strContent = "// Dependencies
@import '../../../../vendor/zurb/foundation/_vendor/normalize-scss/sass/normalize';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/helpers/missing-dependencies';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/helpers/true';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/functions/purge';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/functions/remove';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/functions/replace';
@import '../../../../vendor/zurb/foundation/_vendor/sassy-lists/stylesheets/functions/to-list';

// Sass utilities
@import 'util/util';

// import and modify the default settings
@import 'settings/settings';

// Global variables and styles
@import 'global';
";

        //Loop through all components to make sure we only include ones we want
        foreach($arrAllComponents as $component)
        {
            if(in_array($component, $arrComponentsToInclude))
            {
                $strImport = sprintf($strImportFormat, $component);

                //Import first
                $strContent .= "\n" . $strImport;
            }
        }

        $strContent .= "\n" . '@include foundation-global-styles;';

        //Loop through all components again to include their mixins
        foreach($arrAllComponents as $component)
        {
            if(in_array($component, $arrComponentsToInclude))
            {
                //Split by forward slash
                $arrComponent = explode('/', $component);
                if($arrComponent[1] ==='visibility' || $arrComponent[1] ==='float')
                {
                    $arrComponent[1] .= '-classes';
                }
                if($arrComponent[1]==='flex-grid' || $arrComponent[1]==='flex')
                {
                    $blnFlexGrid = true;
                }
                if($arrComponent[1]==='flex')
                {
                    continue;
                }
                $strInclude = sprintf($strIncludeFormat, $arrComponent[1]);

                //Include second
                $strContent .= "\n" . $strInclude;
            }
        }

        if($blnFlexGrid)
        {
            $strContent .= "\n" . '@include foundation-flex-classes;';
        }

        //Clean up blank lines
        $strContent = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $strContent);
        $objFile->write($strContent);
        $objFile->close();
    }
    
    /**
     * Change the Foundation breakpoints
     * @param \Contao\ThemeModel
     * @param string
     */
    protected static function changeBreakpoints(ThemeModel $objConfig, $strPath)
    {       
        \System::loadLanguageFile('foundation');
            
        $arrRanges = $GLOBALS['TL_LANG']['FOUNDATION']['SCSS']['BREAKPOINT'];
        
        $arrMediumCustom    = deserialize($objConfig->foundation_break_medium);
        $arrLargeCustom     = deserialize($objConfig->foundation_break_large);
        $arrXLargeCustom    = deserialize($objConfig->foundation_break_xlarge);
        $arrXXLargeCustom   = deserialize($objConfig->foundation_break_xxlarge);
        
        $objFile = new File($strPath . '/settings/_settings.scss');
        $strContent = $objFile->getContent();

        $arrRanges = array(
            'medium'    => $arrMediumCustom['value'],
            'large'     => $arrLargeCustom['value'],
            'xlarge'    => $arrXLargeCustom['value'],
            'xxlarge'   => $arrXXLargeCustom['value'],
        );

        foreach($arrRanges as $range => $value)
        {
            if(!empty($value)) {
                $strReplace = $range . ': ' . $arrRanges[$range] . 'px,';
                $strNew = $range . ': ' . $value . 'px,';
                $strContent = str_replace($strReplace, $strNew, $strContent);
            }
        }
        
        $objFile->write($strContent);
        $objFile->close();
    }
    
}
