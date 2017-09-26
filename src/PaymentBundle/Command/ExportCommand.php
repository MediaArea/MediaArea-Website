<?php

namespace PaymentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Constraints\Date;
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
                new InputArgument(
                    'start',
                    InputArgument::REQUIRED,
                    'Start date (<info>YYYY-MM-DD</info><comment>THH:MM:SS</comment>)'.
                    ', <comment>time is optionnal 00:00:00 by default</comment>
                    Could be also <info>YYYY-MM</info> to extract datas of an entire month'
                ),
                new InputArgument(
                    'end',
                    InputArgument::OPTIONAL,
                    'Optional - End date (<info>YYYY-MM-DD</info><comment>THH:MM:SS</comment>)'.
                    ', <comment>time is optionnal 23:59:59 by default</comment>'
                ),
            ))
            ->setHelp(
                <<<'EOT'
The <info>mediaarea:payment:export'</info> export payments datas within a date range
Date format: <info>YYYY-MM-DD</info><comment>THH:MM:SS</comment>

  <info>php %command.full_name% START</info> <comment>END</comment>

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
        )->setParameters([
            'start' => $this->getStartDate($start),
            'end' => $this->getEndDate($start, $end),
        ]);
        $invoices = $query->getScalarResult();

        $output->writeln('Invoices between '.$this->getStartDate($start).' and '.$this->getEndDate($start, $end));

        if (0 == count($invoices)) {
            $output->writeln('No invoices found for the given date range');

            return;
        }

        $output->writeln('AmountExclTax,VAT,Currency,IP,Country,Date');

        foreach ($invoices as $invoice) {
            $output->writeln(sprintf(
                '%s,%s,%s,%s,%s,%s',
                $invoice['i_amount'],
                $invoice['i_vat'],
                $invoice['i_currency'],
                $invoice['i_ipAddress'],
                $invoice['i_country'],
                $invoice['i_date']->format('Y-m-d\TH:i:s')
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

                $this->validateStartDate($start);

                return $start;
            });
            $questions['start'] = $question;
        } else {
            $this->validateStartDate($input->getArgument('start'));
        }

        if (!$this->isDateMonth($input->getArgument('start'))) {
            if (!$input->getArgument('end')) {
                $question = new Question('Please give an end date (could be empty if start date is a month):');
                $question->setValidator(function ($end) use ($input) {
                    if (empty($end)) {
                        if (!$this->isDateMonth($input->getArgument('start'))) {
                            throw new \Exception('End date can not be empty if start date is not a month');
                        }

                        return $end;
                    }

                    $this->validateEndDate($end);

                    return $end;
                });
                $questions['end'] = $question;
            } else {
                $this->validateEndDate($input->getArgument('end'));
            }
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    /**
     * Get the start date for query.
     *
     * @param string $start Start date
     *
     * @return string
     */
    public function getStartDate($start)
    {
        // Default start time
        if ($this->isDate($start)) {
            return $start.'T00:00:00';
        }

        // By month
        if ($this->isDateMonth($start)) {
            return $start.'-01T00:00:00';
        }

        return $start;
    }

    /**
     * Get the end date for query.
     *
     * @param string $start Start date
     * @param string $end   End date
     *
     * @return string
     */
    public function getEndDate($start, $end)
    {
        // Default end time
        if ($this->isDate($end)) {
            $end = $end.'T23:59:59';
        }

        // By month
        if ($this->isDateMonth($start)) {
            $date = new \DateTime($start);
            $end = $date->format('Y-m-t\T23:59:59');
        }

        return $end;
    }

    /**
     * Validate datetime.
     *
     * @var string DateTime to validate
     *
     * @return bool
     */
    protected function isDateTime($dateTime)
    {
        if (null === $dateTime) {
            return false;
        }

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($dateTime, new DateTime(['format' => 'Y-m-d\TH:i:s']));

        return !$errors->count();
    }

    /**
     * Validate date.
     *
     * @var string Date to validate
     *
     * @return bool
     */
    protected function isDate($date)
    {
        if (null === $date) {
            return false;
        }

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($date, new Date());

        return !$errors->count();
    }

    /**
     * Validate month date.
     *
     * @var string Date to validate
     *
     * @return bool
     */
    protected function isDateMonth($date)
    {
        if (null === $date) {
            return false;
        }

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($date, new DateTime(['format' => 'Y-m']));

        return !$errors->count();
    }

    /**
     * Validate start date.
     *
     * @var string Date to validate
     *
     * @return bool|Exception
     */
    protected function validateStartDate($date)
    {
        if ($this->isDateTime($date)) {
            return;
        }
        if ($this->isDate($date)) {
            return;
        }
        if ($this->isDateMonth($date)) {
            return;
        }

        throw new \Exception('Start date is not valid');
    }

    /**
     * Validate end date.
     *
     * @var string Date to validate
     *
     * @return bool|Exception
     */
    protected function validateEndDate($date)
    {
        if ($this->isDateTime($date)) {
            return;
        }
        if ($this->isDate($date)) {
            return;
        }

        throw new \Exception('End date is not valid');
    }
}
