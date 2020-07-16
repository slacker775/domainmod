<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SslProviders
 *
 * @ORM\Entity
 */
class SslProvider
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
     * @ORM\Column(name="url", type="string", length=100, nullable=true)
     * @Assert\Url
     */
    private $url;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToOne(targetEntity="App\Entity\SslFee", mappedBy="sslProvider")
     *
     * @var SslFee
     */
    private $fee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SslAccount", mappedBy="sslProvider")
     * 
     * @var Collection
     */
    private $accounts;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="sslProvider")
     * 
     * @var Collection
     */
    private $certs;
    
    /**
     *
     * @var CreationType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationType")
     * @ORM\JoinColumn(name="creation_type_id", referencedColumnName="id")
     */
    private $creationType;

    use BlameableEntity;    

    use TimestampableEntity;    

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->certs = new ArrayCollection();
    }

    public function getCerts(): Collection
    {
        return $this->certs;
    }

    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function getFee(): ?SslFee
    {
        return $this->fee;
    }

    public function setFee(SslFee $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
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

    public function __toString()
    {
        return $this->name;
    }

}
