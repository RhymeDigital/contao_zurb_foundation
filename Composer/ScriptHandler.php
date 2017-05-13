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

namespace Rhyme\ContaoZurbFoundationBundle\Composer;

use Composer\Script\Event;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Contao\CoreBundle\Composer\ScriptHandler as ContaoScriptHandler;


/**
 * Sets up the environment in a Symfony app.
 *
 */
class ScriptHandler extends ContaoScriptHandler
{

    /**
     * Generates the symlinks.
     *
     * @param Event $event
     */
    public static function generateSymlinks(Event $event)
    {
        self::executeCommand('rhymecontaozurbfoundation:symlinks', $event);
    }

    /**
     * Executes a command.
     *
     * @param string $cmd
     * @param Event  $event
     *
     * @throws \RuntimeException
     */
    private static function executeCommand($cmd, Event $event)
    {
        $phpFinder = new PhpExecutableFinder();

        if (false === ($phpPath = $phpFinder->find())) {
            throw new \RuntimeException('The php executable could not be found.');
        }

        $process = new Process(
            sprintf(
                '%s %s/console %s %s%s%s',
                $phpPath,
                self::getBinDir($event),
                $cmd,
                self::getWebDir($event),
                $event->getIO()->isDecorated() ? ' --ansi' : '',
                self::getVerbosityFlag($event)
            )
        );

        $process->run(
            function ($type, $buffer) use ($event) {
                $event->getIO()->write($buffer, false);
            }
        );

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf('An error occurred while executing the "%s" command.', $cmd));
        }
    }

    /**
     * Returns the bin directory.
     *
     * @param Event $event
     *
     * @return string
     */
    private static function getBinDir(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();

        // Symfony assumes the new directory structure if symfony-var-dir is set
        if (isset($extra['symfony-var-dir']) && is_dir($extra['symfony-var-dir'])) {
            return isset($extra['symfony-bin-dir']) ? $extra['symfony-bin-dir'] : 'bin';
        }

        return isset($extra['symfony-app-dir']) ? $extra['symfony-app-dir'] : 'app';
    }

    /**
     * Returns the web directory.
     *
     * @param Event $event
     *
     * @return string
     */
    private static function getWebDir(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();

        return isset($extra['symfony-web-dir']) ? $extra['symfony-web-dir'] : 'web';
    }

    /**
     * Returns the verbosity flag depending on the console IO verbosity.
     *
     * @param Event $event
     *
     * @return string
     */
    private static function getVerbosityFlag(Event $event)
    {
        $io = $event->getIO();

        switch (true) {
            case $io->isVerbose():
                return ' -v';

            case $io->isVeryVerbose():
                return ' -vv';

            case $io->isDebug():
                return ' -vvv';

            default:
                return '';
        }
    }

}
