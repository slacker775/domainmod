<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainFields
 *
 * @ORM\Table(name="domain_fields")
 * @ORM\Entity
 */
class DomainField
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
     * @ORM\Column(name="name", type="string", length=75, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="field_name", type="string", length=30, nullable=false)
     */
    private $fieldName;

    /**
     *
     * @var CustomFieldType
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomFieldType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

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
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getType(): CustomFieldType
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
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

    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function setType(CustomFieldType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
