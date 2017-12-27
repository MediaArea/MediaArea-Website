<?php

namespace MediaBinBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MediaBinBundle\Entity\Bin;
use MediaBinBundle\Lib\File\File;

class PurgeExpiredBinCommand extends Command
{
    protected $em;
    protected $binFile;

    public function __construct(EntityManagerInterface $entityManager, File $binFile)
    {
        $this->em = $entityManager;
        $this->binFile = $binFile;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mediaarea:mediabin:purge')
            ->setDescription('Purge expired bin.')
            ->setHelp(
                <<<'EOT'
The <info>mediaarea:mediabin:purge</info> command purge the expired bin from DB and storage.

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $binRepository = $this->em->getRepository(Bin::class);
        $count = 0;
        while ($expiredBin = $binRepository->getExpiredBin(10)) {
            foreach ($expiredBin as $bin) {
                $output->writeln($bin->getHash().' - '.$bin->getExpireAt()->format('Y-m-d H:i:s'));
                $this->binFile->delete($bin->getHash());
                $this->em->remove($bin);
                ++$count;
            }
            $this->em->flush();
        }

        if (0 < $count) {
            $output->writeln('<info>'.$count.' bin purged</info>');
        } else {
            $output->writeln('<comment>No bin to purge</comment>');
        }
    }
}
