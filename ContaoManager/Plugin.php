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

namespace Rhyme\ContaoZurbFoundationBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Rhyme\ContaoZurbFoundationBundle\RhymeContaoZurbFoundationBundle;

/**
 * Class Plugin
 *
 * Registers as a plugin with the Contao Manager
 * @copyright  2017 Rhyme Digital
 * @package    Zurb_Foundation
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            (new BundleConfig(RhymeContaoZurbFoundationBundle::class))->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}