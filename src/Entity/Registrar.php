<?php
declare(strict_types = 1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Registrars
 *
 * @ORM\Entity
 */
class Registrar
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
     * @Assert\NotBlank
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
     * @var ApiRegistrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="api_registrar_id", referencedColumnName="id")
     */
    private $apiRegistrar;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="registrar")
     *
     * @var Collection
     */
    private $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\RegistrarAccount", mappedBy="registrar")
     *
     * @var Collection
     */
    private $accounts;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Fee", mappedBy="registrar")
     *
     * @var Fee
     */
    private $fees;

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
        $this->domains = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->fees = new ArrayCollection();
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
        $notes = $notes ?? '';
        $this->notes = $notes;
        return $this;
    }

    public function addDomain(Domain $domain)
    {
        return $this->domains->add($domain->setRegistrar($this));
    }

    public function getDomains(): array
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

    public function getAccounts(): array
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

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
    }
}
