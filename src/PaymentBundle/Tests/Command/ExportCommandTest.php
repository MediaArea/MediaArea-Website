<?php

namespace PaymentBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PaymentBundle\Command\ExportCommand;

class ExportCommandTest extends KernelTestCase
{
    public function testDate()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new ExportCommand());

        $command = $application->find('mediaarea:payment:export');

        // Start and end with time
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'start' => '2017-01-01T10:10:10',
            'end' => '2017-01-01T18:18:18',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Invoices between 2017-01-01T10:10:10 and 2017-01-01T18:18:18', $output);

        // Start and end without time
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'start' => '2017-01-01',
            'end' => '2017-01-02',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Invoices between 2017-01-01T00:00:00 and 2017-01-02T23:59:59', $output);

        // Start without time and end with time
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'start' => '2017-01-01',
            'end' => '2017-01-02T18:18:18',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Invoices between 2017-01-01T00:00:00 and 2017-01-02T18:18:18', $output);

        // Start with time and end without time
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'start' => '2017-01-01T10:10:10',
            'end' => '2017-01-02',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Invoices between 2017-01-01T10:10:10 and 2017-01-02T23:59:59', $output);

        // By month
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'start' => '2017-01',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Invoices between 2017-01-01T00:00:00 and 2017-01-31T23:59:59', $output);
    }
}
