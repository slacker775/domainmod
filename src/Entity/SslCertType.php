<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * SslCertTypes
 *
 * @ORM\Entity
 */
class SslCertType
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
     * @ORM\Column(name="type", type="string", length=100, nullable=false)
     */
    private $type;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SslCert", mappedBy="type")
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

    public function __construct(string $name = null)
    {
        $this->type = $name;
        $this->sslCerts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCreationType(): ?CreationType
    {
        return $this->creationType;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
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
        return $this->type;
    }
}
