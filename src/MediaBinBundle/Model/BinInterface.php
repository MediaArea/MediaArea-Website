<?php

namespace MediaBinBundle\Model;

interface BinInterface
{
    const VISIBILITY_PUBLIC = 0;
    const VISIBILITY_HIDDEN = 1;
    const VISIBILITY_PRIVATE = 2;

    const FORMAT_MEDIAINFO = 1;
}
