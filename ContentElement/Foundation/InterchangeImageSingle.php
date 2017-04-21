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
 
namespace Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation;

use Contao\System;
use Contao\Controller;
use Contao\Validator;
use Contao\FilesModel;
use Rhyme\ContaoZurbFoundationBundle\ContentElement\Foundation as Zurb_Foundation;
 
 /**
 * Class InterchangeImage
 *
 * Creates a an interchange Image that can be used at several different sizes
 * @copyright  2017 Rhyme Digital
 * @author     Blair Winans <blair@rhyme.digital>
 * @package    Zurb_Foundation
 */
class InterchangeImageSingle extends Zurb_Foundation
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_foundation_interchangeimage';


	/**
	 * Return if the image does not exist
	 * @return string
	 */
	public function generate()
	{
		if ($this->singleSRC == '')
		{
			return '';
		}

		$objFile = FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null)
		{
			if (!Validator::isUuid($this->singleSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

		if (!is_file(TL_ROOT . '/' . $objFile->path))
		{
			return '';
		}

		$this->singleSRC = $objFile->path;
		
        if(TL_MODE=='BE')
		{
    		$this->strTemplate = 'ce_image';
		}
		
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
	    //Get the alternate sizes
	    $arrSmallSize   = deserialize($this->foundation_size_small);
	    $arrMediumSize  = deserialize($this->foundation_size_medium);
	    $arrLargeSize   = deserialize($this->foundation_size_large);
	    $arrXLargeSize  = deserialize($this->foundation_size_xlarge);
	    $arrXXLargeSize = deserialize($this->foundation_size_xxlarge);

        $this->Template->smallSrc       = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/'. $this->singleSRC, $arrSmallSize)->getUrl(TL_ROOT);
        $this->Template->mediumSrc      = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/'. $this->singleSRC, $arrMediumSize)->getUrl(TL_ROOT);
        $this->Template->largeSrc       = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/'. $this->singleSRC, $arrLargeSize)->getUrl(TL_ROOT);
        $this->Template->xlargeSrc      = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/'. $this->singleSRC, $arrXLargeSize)->getUrl(TL_ROOT);
        $this->Template->xxlargeSrc     = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/'. $this->singleSRC, $arrXXLargeSize)->getUrl(TL_ROOT);

		Controller::addImageToTemplate($this->Template, $this->arrData);
	}

}
