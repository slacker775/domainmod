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
 * Dns
 *
 * @ORM\Entity
 */
class Dns
{
    use EntityIdTrait;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns1", type="string", length=255, nullable=false)
     */
    private $dns1;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns2", type="string", length=255, nullable=false)
     */
    private $dns2;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns3", type="string", length=255, nullable=true)
     */
    private $dns3;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns4", type="string", length=255, nullable=true)
     */
    private $dns4;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns5", type="string", length=255, nullable=true)
     */
    private $dns5;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns6", type="string", length=255, nullable=true)
     */
    private $dns6;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns7", type="string", length=255, nullable=true)
     */
    private $dns7;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns8", type="string", length=255, nullable=true)
     */
    private $dns8;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns9", type="string", length=255, nullable=true)
     */
    private $dns9;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="dns10", type="string", length=255, nullable=true)
     */
    private $dns10;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip1", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip1;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip2", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip2;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip3", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip3;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip4", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip4;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip5", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip5;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip6", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip6;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip7", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip7;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip8", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip8;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip9", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip9;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip10", type="string", length=45, nullable=true)
     * @Assert\Ip
     */
    private $ip10;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="number_of_servers", type="integer", nullable=false)
     */
    private $numberOfServers;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="dns")
     *
     * @var Collection
     */
    private $domains;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->domains = new ArrayCollection();
        $this->numberOfServers = 0;
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

    public function getDns1(): ?string
    {
        return $this->dns1;
    }

    public function setDns1(string $dns1): self
    {
        $this->dns1 = $dns1;
        return $this;
    }

    public function getDns2(): ?string
    {
        return $this->dns2;
    }

    public function setDns2(?string $dns): self
    {
        $this->dns2 = $dns ?? '';
        return $this;
    }

    public function getDns3(): ?string
    {
        return $this->dns3;
    }

    public function setDns3(?string $dns): self
    {
        $this->dns3 = $dns ?? '';
        return $this;
    }

    public function getDns4(): ?string
    {
        return $this->dns4;
    }

    public function setDns4(?string $dns): self
    {
        $this->dns4 = $dns ?? '';
        return $this;
    }

    public function getDns5(): ?string
    {
        return $this->dns5;
    }

    public function setDns5(?string $dns): self
    {
        $this->dns5 = $dns ?? '';
        return $this;
    }

    public function getDns6(): ?string
    {
        return $this->dns6;
    }

    public function setDns6(?string $dns): self
    {
        $this->dns6 = $dns ?? '';
        return $this;
    }

    public function getDns7(): ?string
    {
        return $this->dns7;
    }

    public function setDns7(?string $dns): self
    {
        $this->dns7 = $dns ?? '';
        return $this;
    }

    public function getDns8(): ?string
    {
        return $this->dns8;
    }

    public function setDns8(?string $dns): self
    {
        $this->dns8 = $dns ?? '';
        return $this;
    }

    public function getDns9(): ?string
    {
        return $this->dns9;
    }

    public function setDns9(?string $dns): self
    {
        $this->dns9 = $dns ?? '';
        return $this;
    }

    public function getDns10(): ?string
    {
        return $this->dns10;
    }

    public function setDns10(?string $dns): self
    {
        $this->dns10 = $dns ?? '';
        return $this;
    }

    public function getIp1(): ?string
    {
        return $this->ip1;
    }

    public function setIp1(?string $ip): self
    {
        $this->ip1 = $ip ?? '';
        return $this;
    }

    public function getIp2(): ?string
    {
        return $this->ip2;
    }

    public function setIp2(?string $ip): self
    {
        $this->ip2 = $ip ?? '';
        return $this;
    }

    public function getIp3(): ?string
    {
        return $this->ip3;
    }

    public function setIp3(?string $ip): self
    {
        $this->ip3 = $ip ?? '';
        return $this;
    }

    public function getIp4(): ?string
    {
        return $this->ip4;
    }

    public function setIp4(?string $ip): self
    {
        $this->ip4 = $ip ?? '';
        return $this;
    }

    public function getIp5(): ?string
    {
        return $this->ip5;
    }

    public function setIp5(?string $ip): self
    {
        $this->ip5 = $ip ?? '';
        return $this;
    }

    public function getIp6(): ?string
    {
        return $this->ip6;
    }

    public function setIp6(?string $ip): self
    {
        $this->ip6 = $ip ?? '';
        return $this;
    }

    public function getIp7(): ?string
    {
        return $this->ip7;
    }

    public function setIp7(?string $ip): self
    {
        $this->ip7 = $ip ?? '';
        return $this;
    }

    public function getIp8(): ?string
    {
        return $this->ip8;
    }

    public function setIp8(?string $ip): self
    {
        $this->ip8 = $ip ?? '';
        return $this;
    }

    public function getIp9(): ?string
    {
        return $this->ip9;
    }

    public function setIp9(?string $ip): self
    {
        $this->ip9 = $ip ?? '';
        return $this;
    }

    public function getIp10(): ?string
    {
        return $this->ip10;
    }

    public function setIp10(?string $ip): self
    {
        $this->ip10 = $ip ?? '';
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getNumberOfServers(): int
    {
        return $this->numberOfServers;
    }

    public function setNumberOfServers(int $numberOfServers): self
    {
        $this->numberOfServers = $numberOfServers;
        return $this;
    }

    public function getActiveDomains(): Collection
    {
        return $this->getDomains()
            ->filter(function (Domain $domain) {
                return $domain->getStatus() != '0' && $domain->getStatus() != '10';
            });
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }
}
