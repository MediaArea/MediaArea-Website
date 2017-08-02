<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Constraints\Email;

class DonorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mediaarea:user:donor')
            ->setDescription('Create a donor user or promote an existing user.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('amount', InputArgument::REQUIRED, 'Amount donated'),
                new InputArgument('name', InputArgument::OPTIONAL, 'Name'),
            ))
            ->setHelp(
                <<<'EOT'
The <info>mediaarea:user:donor'</info> command creates or update a user and promote it to donor:

  <info>php %command.full_name% EMAIL</info>

This interactive shell will ask you for an amount.

You can alternatively specify the amount as the second argument:

  <info>php %command.full_name% EMAIL AMOUNT</info>

You can optionnaly give a name as the third argument:

  <info>php %command.full_name% EMAIL AMOUNT NAME</info>

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $amount = $input->getArgument('amount');
        $name = $input->getArgument('name');

        $manipulator = $this->getContainer()->get('user.util.donor_manipulator');
        $manipulator->createOrPromoteDonor($email, $amount, $name);

        $output->writeln(sprintf('Created or updated user <comment>%s</comment>', $email));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }

                $this->validateEmail($email);

                return $email;
            });
            $questions['email'] = $question;
        } else {
            $this->validateEmail($input->getArgument('email'));
        }

        if (!$input->getArgument('amount')) {
            $question = new Question('Please give an amount:');
            $question->setValidator(function ($amount) {
                if (empty($amount)) {
                    throw new \Exception('Amount can not be empty');
                }

                return $amount;
            });
            $questions['amount'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    /**
     * Validate email address.
     *
     * @var email
     */
    protected function validateEmail($email)
    {
        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($email, new Email());
        if ($errors->count()) {
            throw new \Exception('Email is not valid');
        }
    }
}
