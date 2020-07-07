<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueueList
 *
 * @ORM\Table(name="domain_queue_list")
 * @ORM\Entity
 */
class DomainQueueList
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
     * @var ApiRegistrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="api_registrar_id", referencedColumnName="id")
     */
    private $apiRegistrar;

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     *
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     *
     * @var RegistrarAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="domain_count", type="integer", nullable=false)
     */
    private $domainCount;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="processing", type="boolean", nullable=false)
     */
    private $processing;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ready_to_import", type="boolean", nullable=false)
     */
    private $readyToImport;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="copied_to_history", type="boolean", nullable=false)
     */
    private $copiedToHistory;

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

    public function __construct()
    {
        $this->domainCount = 0;
        $this->processing = false;
        $this->readyToImport = false;
        $this->finished = false;
        $this->copiedToHistory = false;
        $this->created = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getApiRegistrar(): ApiRegistrar
    {
        return $this->apiRegistrar;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    public function getAccount(): RegistrarAccount
    {
        return $this->account;
    }

    public function getDomainCount(): int
    {
        return $this->domainCount;
    }

    public function isProcessing(): bool
    {
        return $this->processing;
    }

    public function isReadyToImport(): bool
    {
        return $this->readyToImport;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function isCopiedToHistory(): bool
    {
        return $this->copiedToHistory;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function setApiRegistrar(ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
        return $this;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function setAccount(RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function setDomainCount(int $domainCount): self
    {
        $this->domainCount = $domainCount;
        return $this;
    }

    public function setProcessing(bool $processing = true): self
    {
        $this->processing = $processing;
        return $this;
    }

    public function setReadyToImport(bool $readyToImport = true): self
    {
        $this->readyToImport = $readyToImport;
        return $this;
    }

    public function setFinished(bool $finished = true): self
    {
        $this->finished = $finished;
        return $this;
    }

    public function setCopiedToHistory(bool $copiedToHistory = true): self
    {
        $this->copiedToHistory = $copiedToHistory;
        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
