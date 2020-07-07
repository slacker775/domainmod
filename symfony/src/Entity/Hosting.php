<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hosting
 *
 * @ORM\Table(name="hosting")
 * @ORM\Entity
 */
class Hosting
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
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="hostingProvider")
     *
     * @var Collection
     */
    private $domains;

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
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setUrl(?string $url): self
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

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
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
}