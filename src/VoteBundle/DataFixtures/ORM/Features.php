<?php

namespace VoteBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use VoteBundle\Entity\Feature;
use VoteBundle\Model\FeatureInterface;

class Features extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $feature = new Feature();
        $feature->setId(1)->setTitle('A super feature title')
            ->setDescription('A super feature description')
            ->setVotesTarget(50)
            ->setStatus(FeatureInterface::STATUS_OPEN);
        $manager->persist($feature);

        // Force ID
        $metadata = $manager->getClassMetaData(get_class($feature));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

        $feature = new Feature();
        $feature->setId(2)->setTitle('Another super feature title')
            ->setDescription('Another super feature description')
            ->setVotesTarget(200)
            ->setStatus(FeatureInterface::STATUS_OPEN);
        $manager->persist($feature);

        $feature = new Feature();
        $feature->setId(3)->setTitle('A close feature title')
            ->setDescription('A close feature description')
            ->setVotesTarget(10)
            ->setStatus(FeatureInterface::STATUS_CLOSE);
        $manager->persist($feature);

        $manager->flush();
    }
}
