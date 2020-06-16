<?php
namespace App\Doctrine;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

trait CleanAssociationsTrait
{

    /**
     *
     * @ORM\PostLoad
     */
    public function cleanAssociations(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $data = $eventArgs->getEntityManager()
            ->getUnitOfWork()
            ->getOriginalEntityData($entity);

        // For each association
        foreach ($eventArgs->getEntityManager()
            ->getClassMetadata(get_class($entity))
            ->getAssociationMappings() as $associationMapping) {

            // Check if it's a ManyToOne relationship
            if (isset($associationMapping['fieldName']) && isset($associationMapping['joinColumns']) && is_array($associationMapping['joinColumns']) && count($associationMapping['joinColumns']) === 1 && isset($associationMapping['joinColumns'][0]['name'])) {

                // Get relation fieldName and the associated column name
                $fieldName = $associationMapping['fieldName'];
                $columnName = $associationMapping['joinColumns'][0]['name'];

                // Check raw data == 0 => set field to null
                if ($data[$columnName] == 0 && is_callable([
                    $entity,
                    'set' . $fieldName
                ]))
                    $entity->{'set' . $fieldName}(null);
            }
        }
    }
}