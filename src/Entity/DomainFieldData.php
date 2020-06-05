<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainFieldData
 *
 * @ORM\Table(name="domain_field_data")
 * @ORM\Entity
 */
class DomainFieldData
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
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId;

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;
    
    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;
    
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }


}
