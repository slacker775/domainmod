<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Categories
 *
 * @ORM\Entity
 */
class Category
{

    use EntityIdTrait;

    /**
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private string $name;

    /**
     *
     * @ORM\Column(name="stakeholder", type="string", length=100, nullable=true)
     */
    private string $stakeholder;

    /**
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private string $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="category")
     */
    private Collection $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="category")
     */
    private Collection $sslCerts;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->domains = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
    }

    public static function create(string $name, string $stakeholder): self
    {
        $obj = new self();
        $obj->setName($name)
            ->setStakeholder($stakeholder);
        return $obj;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getStakeholder(): ?string
    {
        return $this->stakeholder;
    }

    public function setStakeholder(?string $stakeholder): self
    {
        $stakeholder = $stakeholder ?? '';
        $this->stakeholder = $stakeholder;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $notes = $notes ?? '';
        $this->notes = $notes;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;
        return $this;
    }

    public function getSslCerts(): Collection
    {
        return $this->sslCerts;
    }

    public function setSslCerts(Collection $sslCerts): self
    {
        $this->sslCerts = $sslCerts;
        return $this;
    }
}
