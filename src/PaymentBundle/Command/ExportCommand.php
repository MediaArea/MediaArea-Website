<?php

namespace PaymentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Constraints\DateTime;

class ExportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mediaarea:payment:export')
            ->setDescription('Export payment datas.')
            ->setDefinition(array(
                new InputArgument('start', InputArgument::REQUIRED, 'Start date (<info>YYYY-MM-DD HH:MM:SS</info>)'),
                new InputArgument('end', InputArgument::REQUIRED, 'End date (<info>YYYY-MM-DD HH:MM:SS</info>)'),
            ))
            ->setHelp(
                <<<'EOT'
The <info>mediaarea:payment:export'</info> export payment datas within a date range
Date format: <info>YYYY-MM-DD HH:MM:SS</info>

  <info>php %command.full_name% START END</info>

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = $input->getArgument('start');
        $end = $input->getArgument('end');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $query = $em->createQuery(
            'SELECT i
            FROM PaymentBundle:Invoice i
            WHERE i.date >= :start AND i.date <= :end
            ORDER BY i.date ASC'
        )->setParameters(['start' => $start, 'end' => $end]);
        $invoices = $query->getScalarResult();

        if (0 == count($invoices)) {
            $output->writeln('No invoices found for the given range date');

            return;
        }

        $output->writeln('Amount;VAT;Currency;IP;Country;Date');

        foreach ($invoices as $invoice) {
            $output->writeln(sprintf(
                '%s;%s;%s;%s;%s;%s',
                $invoice['i_amount'],
                $invoice['i_vat'],
                $invoice['i_currency'],
                $invoice['i_ipAddress'],
                $invoice['i_country'],
                $invoice['i_date']->format('Y-m-d H:i:s')
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('start')) {
            $question = new Question('Please give a start date:');
            $question->setValidator(function ($start) {
                if (empty($start)) {
                    throw new \Exception('Start date can not be empty');
                }

                $this->validateDate($start, 'Start');

                return $start;
            });
            $questions['start'] = $question;
        } else {
            $this->validateDate($input->getArgument('start'), 'Start');
        }

        if (!$input->getArgument('end')) {
            $question = new Question('Please give an end date:');
            $question->setValidator(function ($end) {
                if (empty($end)) {
                    throw new \Exception('End date can not be empty');
                }

                $this->validateDate($end, 'End');

                return $end;
            });
            $questions['end'] = $question;
        } else {
            $this->validateDate($input->getArgument('end'), 'End');
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    /**
     * Validate datetime.
     *
     * @var $date
     */
    protected function validateDate($date, $inputName)
    {
        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($date, new DateTime());
        if ($errors->count()) {
            throw new \Exception($inputName . ' date is not valid');
        }
    }
}
