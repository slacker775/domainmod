<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Owners
 *
 * @ORM\Table(name="owners", indexes={@ORM\Index(name="name", columns={"name"})})
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

    /**
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

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
        $this->domains = new ArrayCollection();
        $this->registrarAccounts = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
        $this->sslAccounts = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
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

    public function getCreatedBy(): User
    {
        return $this->createdBy;
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

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
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
