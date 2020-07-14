<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueueListHistory
 *
 * @ORM\Table(name="domain_queue_list_history")
 * @ORM\Entity
 */
class DomainQueueListHistory
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
     * @var int
     *
     * @ORM\Column(name="domain_count", type="integer", nullable=false)
     */
    private $domainCount;

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
        $this->created = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomainCount(): int
    {
        return $this->domainCount;
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

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function setDomainCount(int $domainCount): self
    {
        $this->domainCount = $domainCount;
    }

    public function setApiRegistrar(ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
    }

    public function setAccount(RegistrarAccount $account): self
    {
        $this->account = $account;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
    }
}
