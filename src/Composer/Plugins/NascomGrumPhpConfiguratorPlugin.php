<?php

namespace Nascom\GrumPhpSymfony\Composer\Plugins;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class NascomGrumPhpConfiguratorPlugin
 *
 * @package Nascom\GrumPhpSymfony\Composer\Plugins
 */
class NascomGrumPhpConfiguratorPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var
     */
    private $io;

    /**
     * Apply plugin modifications to Composer
     *
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * * The method name to call (priority defaults to 0)
     * * An array composed of the method name to call and the priority
     * * An array of arrays composed of the method names to call and respective
     *   priorities, or 0 if unset
     *
     * For instance:
     *
     * * array('eventName' => 'methodName')
     * * array('eventName' => array('methodName', $priority))
     * * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'post-package-install' => 'configureGrumPhp',
            'post-package-update' => 'configureGrumPhp',
        ];
    }

    public function configureGrumPhp() {
        $this->io->write(
            '<fg=green>Copying grumphp.yml</fg=green>'
        );

        if (!copy(__DIR__ . '/../../../grumphp.yml.dist', './grumphp.yml')) {
            $this->io->write(
                '<fg=red>Copying config failed!</fg=red>'
            );
            return;
        }

        $this->io->write(
            '<fg=green>Copying config success!</fg=green>'
        );
    }
}