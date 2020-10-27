<?php

namespace Tests\Unit;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use ComposerSecurityCheck\SecurityCheckPlugin;
use ComposerSecurityCheck\Command\CommandProvider;
use Tests\TestCase;

class SecurityCheckPluginTest extends TestCase
{
    public function testCapabilities()
    {
        $capabilities = (new SecurityCheckPlugin)->getCapabilities();

        $this->assertArrayHasKey(CommandProviderCapability::class, $capabilities);
        $this->assertEquals($capabilities[CommandProviderCapability::class], CommandProvider::class);
    }
}
