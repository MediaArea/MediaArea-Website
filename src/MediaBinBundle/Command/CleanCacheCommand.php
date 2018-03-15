<?php

namespace MediaBinBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use MediaBinBundle\Lib\File\File;

class CleanCacheCommand extends Command
{
    protected $binFile;

    public function __construct(File $binFile)
    {
        $this->binFile = $binFile;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mediaarea:mediabin:cleancache')
            ->setDescription('Clean local cache.')
            ->setHelp(
                <<<'EOT'
The <info>mediaarea:mediabin:purge</info> command clean local cache.

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->binFile->isExternalEnabled()) {
            $output->writeln('<comment>External files are not enabled, no clean cache to do.</comment>');

            return;
        }

        $finder = new Finder();
        $finder->files()->name('*.xml')->date('until 30 days ago');
        $count = 0;
        foreach ($finder->in($this->binFile->getPath()) as $file) {
            $output->writeln($file->getRealPath());
            unlink($file->getRealPath());
            ++$count;
        }

        if (0 < $count) {
            $output->writeln('<info>'.$count.' bin files expunged from cache</info>');
        } else {
            $output->writeln('<comment>No bin file to expunge from cache</comment>');
        }
    }
}
