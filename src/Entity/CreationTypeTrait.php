<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait CreationTypeTrait
{
    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationType")
     */
    private CreationType $creationType;


    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
    }
}