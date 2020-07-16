<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * Categories
 *
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="stakeholder", type="string", length=100, nullable=true)
     */
    private $stakeholder;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="category")
     * @var Collection
     */
    private $domains;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="category")
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

    use BlameableEntity;    

    use TimestampableEntity;    

    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->sslCerts = new ArrayCollection();
    }

    public static function create(string $name, string $stakeholder): self
    {
        $obj = new self();
        $obj->setName($name)->setStakeholder($stakeholder);
        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStakeholder(): ?string
    {
        return $this->stakeholder;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreationType(): ?CreationType
    {
        return $this->creationType;
    }

    public function setStakeholder(?string $stakeholder): self
    {
        $stakeholder = $stakeholder ?? '';
        $this->stakeholder = $stakeholder;
        return $this;
    }

    public function setNotes(?string $notes): self
    {
        $notes = $notes ?? '';
        $this->notes = $notes;
        return $this;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
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

    public function getSslCerts(): Collection
    {
        return $this->sslCerts;
    }

    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;
        return $this;
    }

    public function setSslCerts(Collection $sslCerts): self
    {
        $this->sslCerts = $sslCerts;
        return $this;
    }
}
