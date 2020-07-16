<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SslAccounts
 *
 * @ORM\Entity
 */
class SslAccount
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
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="sslAccounts")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     *
     * @var SslProvider
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslProvider", inversedBy="accounts")
     * @ORM\JoinColumn(name="ssl_provider_id", referencedColumnName="id")
     */
    private $sslProvider;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=true)
     * @Assert\Email
     */
    private $emailAddress;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="reseller", type="boolean", nullable=false)
     */
    private $reseller;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="reseller_id", type="string", length=100, nullable=true)
     */
    private $resellerId;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="account")
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
        $this->reseller = false;
        $this->certs = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function getSslProvider(): ?SslProvider
    {
        return $this->sslProvider;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function isReseller(): bool
    {
        return $this->reseller;
    }

    public function getResellerId(): ?string
    {
        return $this->resellerId;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function setOwner($owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setSslProvider(SslProvider $sslProvider): self
    {
        $this->sslProvider = $sslProvider;
        return $this;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setReseller(bool $reseller = true): self
    {
        $this->reseller = $reseller;
        return $this;
    }

    public function setResellerId(?string $resellerId): self
    {
        $this->resellerId = $resellerId;
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
    
    public function getCerts(): Collection
    {
        return $this->certs;
    }
    
    public function __toString()
    {
        return sprintf("%s (%s)", $this->getSslProvider()->getName(), $this->username);
    }
}
