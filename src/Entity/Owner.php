<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Owners
 *
 * @ORM\Table(name="owners", indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Owner
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     * @var bool
     *
     * @ORM\Column(name="creation_type_id", type="boolean", nullable=false, options={"default"="2"})
     */
    private $creationTypeId = '2';

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime = '\'1970-01-01 00:00:00\'';

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
