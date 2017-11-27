<?php

namespace VoteBundle\Model;

interface FeatureInterface
{
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_FINISH = 3;

    public function getCompletionRatio();

    public function addVotesCountCache($votesCountCache);
}
