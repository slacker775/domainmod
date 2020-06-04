<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreationTypes
 *
 * @ORM\Table(name="creation_types")
 * @ORM\Entity
 */
class CreationType
{

    /**
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime;

    public function __construct()
    {
        $this->insertTime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInsertTime(): \DateTime
    {
        return $this->insertTime;
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
