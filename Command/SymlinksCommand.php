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

namespace Rhyme\ContaoZurbFoundationBundle\Command;

use Contao\CoreBundle\Util\SymlinkUtil;
use Contao\CoreBundle\Command\SymlinksCommand as ContaoSymlinksCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Sets up the environment in a Symfony app.
 *
 */
class SymlinksCommand extends ContaoSymlinksCommand
{
    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var int
     */
    private $statusCode = 0;

    protected function configure()
    {
        $this
            ->setName('rhymecontaozurbfoundation:symlinks')
            ->setDefinition([
                new InputArgument('target', InputArgument::OPTIONAL, 'The target directory', 'web'),
            ])
            ->setDescription('Symlinks the public resources into the web directory.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeLocked(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->rootDir = dirname($this->getContainer()->getParameter('kernel.root_dir'));
        $this->webDir = rtrim($input->getArgument('target'), '/');

        $this->generateSymlinks();

        if (!empty($this->rows)) {
            $this->io->newLine();
            $this->io->table(['', 'Symlink', 'Target / Error'], $this->rows);
        }

        return $this->statusCode;
    }

    /**
     * Generates the symlinks in the web directory.
     */
    private function generateSymlinks()
    {
        // Symlink the assets and themes directory
        $this->symlink('vendor/components/modernizr', $this->webDir.'/vendor/components/modernizr');
        $this->symlink('vendor/components/jquery', $this->webDir.'/vendor/components/jquery');
        $this->symlink('vendor/zurb/foundation', $this->webDir.'/vendor/zurb/foundation');
    }

    /**
     * Generates a symlink.
     *
     * The method will try to generate relative symlinks and fall back to generating
     * absolute symlinks if relative symlinks are not supported (see #208).
     *
     * @param string $target
     * @param string $link
     */
    private function symlink($target, $link)
    {
        $target = strtr($target, '\\', '/');
        $link = strtr($link, '\\', '/');

        try {
            SymlinkUtil::symlink($target, $link, $this->rootDir);

            $this->rows[] = [
                sprintf(
                    '<fg=green;options=bold>%s</>',
                    '\\' === DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" // HEAVY CHECK MARK (U+2714)
                ),
                $link,
                $target,
            ];
        } catch (\Exception $e) {
            $this->statusCode = 1;

            $this->rows[] = [
                sprintf(
                    '<fg=red;options=bold>%s</>',
                    '\\' === DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" // HEAVY BALLOT X (U+2718)
                ),
                $link,
                sprintf('<error>%s</error>', $e->getMessage()),
            ];
        }
    }
}
