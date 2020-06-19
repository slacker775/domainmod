<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IpAddresses
 *
 * @ORM\Table(name="ip_addresses")
 * @ORM\Entity
 */
class IpAddress
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
     * @ORM\Column(name="ip", type="string", length=45, nullable=false)
     */
    private $ip;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="rdns", type="string", length=255, nullable=true)
     */
    private $rdns;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="ip")
     *
     * @var Collection
     */
    private $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="ip")
     *
     * @var Collection
     */
    private $sslCerts;

    /**
     *
     * @var CreationType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationType")
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
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        if (is_string($this->id) === true) {
            $this->id = intval($this->id);
        }
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getRdns(): ?string
    {
        return $this->rdns;
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

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function setRdns(?string $rdns): self
    {
        $this->rdns = $rdns;
        return $this;
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

    public function __toString()
    {
        return sprintf("%s (%s)", $this->name, $this->ip);
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
