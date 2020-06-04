<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=30, nullable=false)
     */
    private $username;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=false)
     */
    private $emailAddress;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="new_password", type="boolean", nullable=false, options={"default"="1"})
     */
    private $newPassword;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="admin", type="boolean", nullable=false)
     */
    private $admin;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="read_only", type="boolean", nullable=false, options={"default"="1"})
     */
    private $readOnly;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="number_of_logins", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $numberOfLogins;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $lastLogin;

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
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime;

    public function __construct()
    {
        $this->newPassword = true;
        $this->admin = false;
        $this->readOnly = true;
        $this->active = true;
        $this->numberOfLogins = 0;
        $this->lastLogin = null;
        $this->insertTime = new \DateTime();
        $this->updateTime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isNewPassword(): bool
    {
        return $this->newPassword;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getNumberOfLogins(): int
    {
        return $this->numberOfLogins;
    }

    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setNewPassword(bool $newPassword = true): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function setAdmin(bool $admin = true): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function setReadOnly(bool $readOnly = true): self
    {
        $this->readOnly = $readOnly;
        return $this;
    }

    public function setActive(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }

    public function setNumberOfLogins(int $numberOfLogins): self
    {
        $this->numberOfLogins = $numberOfLogins;
        return $this;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
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

    public function __toString()
    {
        return $this->username;
    }
}
