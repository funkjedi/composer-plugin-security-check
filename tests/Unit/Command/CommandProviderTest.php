<?php

namespace Tests\Unit\Command;

use ComposerSecurityCheck\Command\CommandProvider;
use ComposerSecurityCheck\Command\SecurityCheckCommand;
use Tests\TestCase;

class CommandProviderTest extends TestCase
{
    public function testSecurityCommandPresence()
    {
        $commands = (new CommandProvider)->getCommands();

        $this->assertInstanceOf(SecurityCheckCommand::class, $commands[0]);
    }
}
