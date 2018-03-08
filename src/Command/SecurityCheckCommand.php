<?php

namespace ComposerSecurityCheck\Command;

use Composer\Command\BaseCommand;
use Composer\Plugin\CommandEvent;
use Composer\Plugin\PluginEvents;
use SensioLabs\Security\Exception\ExceptionInterface;
use SensioLabs\Security\Formatters\JsonFormatter;
use SensioLabs\Security\Formatters\SimpleFormatter;
use SensioLabs\Security\Formatters\TextFormatter;
use SensioLabs\Security\SecurityChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

//-- Based almost entirely on the command provided by the SensioLabs Security Checker
//-- MIT License | https://github.com/sensiolabs/security-checker/
class SecurityCheckCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('check-security')
            ->setDefinition([
                new InputOption('format', '', InputOption::VALUE_REQUIRED, 'The output format', 'text'),
                new InputOption('end-point', '', InputOption::VALUE_REQUIRED, 'The security checker server URL'),
                new InputOption('timeout', '', InputOption::VALUE_REQUIRED, 'The HTTP timeout in seconds'),
            ])
            ->setDescription('Checks security issues in your project dependencies.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command looks for security issues in the
project dependencies:

<info>php %command.full_name%</info>

By default, the command displays the result in plain text, but you can also
configure it to output JSON instead by using the <info>--format</info> option:

<info>php %command.full_name% --format=json</info>
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $composer = $this->getComposer();

        $commandEvent = new CommandEvent(PluginEvents::COMMAND, 'check-security', $input, $output);
        $composer->getEventDispatcher()->dispatch($commandEvent->getName(), $commandEvent);

        $lockfile = getcwd() . '/composer.json';

        $checker = new SecurityChecker;

        if ($endPoint = $input->getOption('end-point')) {
            $checker->getCrawler()->setEndPoint($endPoint);
        }

        if ($timeout = $input->getOption('timeout')) {
            $checker->getCrawler()->setTimeout($timeout);
        }

        try {
            $vulnerabilities = $checker->check($lockfile);
        } catch (ExceptionInterface $e) {
            $output->writeln($this->getHelperSet()->get('formatter')->formatBlock($e->getMessage(), 'error', true));

            return 1;
        }

        switch ($input->getOption('format')) {
            case 'json':
                $formatter = new JsonFormatter;
                break;
            case 'simple':
                $formatter = new SimpleFormatter($this->getHelperSet()->get('formatter'));
                break;
            case 'text':
            default:
                $formatter = new TextFormatter($this->getHelperSet()->get('formatter'));
        }

        if (!is_array($vulnerabilities)) {
            $output->writeln($this->getHelperSet()->get('formatter')->formatBlock('Security Checker Server returned garbage.', 'error', true));

            return 127;
        }

        $formatter->displayResults($output, $lockfile, $vulnerabilities);

        if ($checker->getLastVulnerabilityCount() > 0) {
            return 1;
        }
    }
}
