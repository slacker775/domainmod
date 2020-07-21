<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * DomainQueueList
 *
 * @ORM\Entity
 */
class DomainQueueList
{

    use EntityIdTrait;

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

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->domainCount = 0;
        $this->processing = false;
        $this->readyToImport = false;
        $this->finished = false;
        $this->copiedToHistory = false;
    }

    public function getApiRegistrar(): ApiRegistrar
    {
        return $this->apiRegistrar;
    }

    public function setApiRegistrar(ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function getAccount(): RegistrarAccount
    {
        return $this->account;
    }

    public function setAccount(RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function getDomainCount(): int
    {
        return $this->domainCount;
    }

    public function setDomainCount(int $domainCount): self
    {
        $this->domainCount = $domainCount;
        return $this;
    }

    public function isProcessing(): bool
    {
        return $this->processing;
    }

    public function setProcessing(bool $processing = true): self
    {
        $this->processing = $processing;
        return $this;
    }

    public function isReadyToImport(): bool
    {
        return $this->readyToImport;
    }

    public function setReadyToImport(bool $readyToImport = true): self
    {
        $this->readyToImport = $readyToImport;
        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished = true): self
    {
        $this->finished = $finished;
        return $this;
    }

    public function isCopiedToHistory(): bool
    {
        return $this->copiedToHistory;
    }

    public function setCopiedToHistory(bool $copiedToHistory = true): self
    {
        $this->copiedToHistory = $copiedToHistory;
        return $this;
    }

}
