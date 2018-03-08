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
    /**
     * Apply plugin modifications to Composer
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        //
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
