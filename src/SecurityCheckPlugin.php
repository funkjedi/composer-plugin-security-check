<?php

namespace ComposerSecurityCheck;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Composer\Plugin\Capable as CapableInterface;
use Composer\Plugin\PluginInterface;
use ComposerSecurityCheck\Command\CommandProvider;

class SecurityCheckPlugin implements PluginInterface, CapableInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        // do nothing
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // do nothing
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // do nothing
    }

    /**
     * @return array
     */
    public function getCapabilities()
    {
        return [
            CommandProviderCapability::class => CommandProvider::class
        ];
    }
}
