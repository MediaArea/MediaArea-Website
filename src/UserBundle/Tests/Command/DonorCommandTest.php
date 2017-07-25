<?php

namespace UserBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UserBundle\Command\DonorCommand;

class DonorCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new DonorCommand());

        $command = $application->find('mediaarea:user:donor');

        // Minimal command
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'email' => 'test@test.com',
            'amount' => '10',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Created or updated user test@test.com', $output);

        // Command with name
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'email' => 'test@test.com',
            'amount' => '10',
            'name' => 'Test',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Created or updated user test@test.com', $output);

        // Invalid email
        $this->expectException(\Exception::class);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'email' => 'invalidEmail',
            'amount' => '10',
        ));
    }
}
