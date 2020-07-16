<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * Owners
 *
 * @ORM\Entity
 */
class Owner
{

    /**
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
    
    /**
     *
     * @var CreationType
     *
     * @ORM\JoinColumn(name="creation_type_id", referencedColumnName="id")
     */
    private $creationType;

    use BlameableEntity;    

    use TimestampableEntity;    

    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->registrarAccounts = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
        $this->sslAccounts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
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
    
    public function getRegistrarAccounts(): Collection
    {
        return $this->registrarAccounts;
    }
    
    public function getSslCerts(): Collection
    {
        return $this->sslCerts;
    }
    
    public function getSslAccounts(): Collection
    {
        return $this->sslAccounts;
    }
    
    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;
        return $this;
    }
    
    public function setRegistrarAccounts(Collection $registrarAccounts): self
    {
        $this->registrarAccounts = $registrarAccounts;
        return $this;
    }
    
    public function setSslCerts(Collection $sslCerts): self
    {
        $this->sslCerts = $sslCerts;
        return $this;
    }
    
    public function setSslAccounts(Collection $sslAccounts): self
    {
        $this->sslAccounts = $sslAccounts;
        return $this;
    }
}
