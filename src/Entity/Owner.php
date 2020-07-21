<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Owners
 *
 * @ORM\Entity
 */
class Owner
{

    use EntityIdTrait;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="owner")
     * @var Collection
     */
    private $domains;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RegistrarAccount", mappedBy="owner")
     * @var Collection
     */
    private $registrarAccounts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="owner")
     * @var Collection
     */
    private $sslCerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SslAccount", mappedBy="owner")
     * @var Collection
     */
    private $sslAccounts;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->domains = new ArrayCollection();
        $this->registrarAccounts = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
        $this->sslAccounts = new ArrayCollection();
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
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

    public function getRegistrarAccounts(): Collection
    {
        return $this->registrarAccounts;
    }

    public function setRegistrarAccounts(Collection $registrarAccounts): self
    {
        $this->registrarAccounts = $registrarAccounts;
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

    public function getSslAccounts(): Collection
    {
        return $this->sslAccounts;
    }

    public function setSslAccounts(Collection $sslAccounts): self
    {
        $this->sslAccounts = $sslAccounts;
        return $this;
    }
}
