<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 */
class CustomFieldType
{

use EntityIdTrait;

    /**
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private string $name;

    use TimestampableEntity;   

    public function __construct(string $name = null)
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
}
