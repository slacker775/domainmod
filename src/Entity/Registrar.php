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
 *
 * @ORM\Entity
 */
class Registrar
{

    use EntityIdTrait;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private ?string $name;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Url
     */
    private ?string $url;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     */
    private ?ApiRegistrar $apiRegistrar;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="registrar")
     */
    private Collection $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\RegistrarAccount", mappedBy="registrar")
     */
    private Collection $accounts;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Fee", mappedBy="registrar", cascade={"remove"})
     */
    private Collection $fees;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->name = null;
        $this->url = null;
        $this->apiRegistrar = null;
        $this->notes = null;
        $this->domains = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->fees = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
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

    public function addDomain(Domain $domain)
    {
        return $this->domains->add($domain->setRegistrar($this));
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function numDomains(): int
    {
        return $this->domains->count();
    }

    public function addAccount(RegistrarAccount $account)
    {
        return $this->accounts->add($account->setRegistrar($this));
    }

    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function numAccounts(): int
    {
        return $this->accounts->count();
    }

    public function getApiRegistrar(): ?ApiRegistrar
    {
        return $this->apiRegistrar;
    }

    public function setApiRegistrar(?ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
