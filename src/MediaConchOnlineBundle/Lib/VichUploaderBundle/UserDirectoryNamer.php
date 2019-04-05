<?php

namespace MediaConchOnlineBundle\Lib\VichUploaderBundle;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class UserDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        if ($object->getUser()) {
            return $object->getUser()->getId();
        }

        return null;
    }
}
