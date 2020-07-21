<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CreationTypes
 *
 * @ORM\Entity
 */
class CreationType
{
    use EntityIdTrait;

    /**
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private string $name;

    use TimestampableEntity;    

    public function __construct(string $name)
    {
        $this->generateId();
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
