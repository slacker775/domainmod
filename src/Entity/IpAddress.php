<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IpAddresses
 *
 * @ORM\Entity
 */
class IpAddress
{
    use EntityIdTrait;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="string", length=45, nullable=false)
     * @Assert\Ip
     */
    private string $ip;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Hostname
     */
    private ?string $rdns;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="ip")
     */
    private Collection $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="ip")
     */
    private Collection $sslCerts;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->name = '';
        $this->ip = '';
        $this->rdns = null;
        $this->notes = null;
        $this->domains = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
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

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getRdns(): ?string
    {
        return $this->rdns;
    }

    public function setRdns(?string $rdns): self
    {
        $this->rdns = $rdns;
        return $this;
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

    public function __toString()
    {
        return sprintf("%s (%s)", $this->name, $this->ip);
    }
}
