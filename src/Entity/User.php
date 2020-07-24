<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{

    use EntityIdTrait;

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
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private ?DateTimeInterface $lastLogin;

    /**
     *
     * @ORM\OneToOne(targetEntity="App\Entity\UserSetting", mappedBy="user", cascade={"persist"})
     */
    private UserSetting $settings;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->newPassword = true;
        $this->admin = false;
        $this->readOnly = true;
        $this->active = true;
        $this->numberOfLogins = 0;
        $this->lastLogin = null;
        $this->settings = new UserSetting();
        $this->settings->setUser($this);
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function isNewPassword(): bool
    {
        return $this->newPassword;
    }

    public function setNewPassword(bool $newPassword = true): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }

    public function getNumberOfLogins(): int
    {
        return $this->numberOfLogins;
    }

    public function setNumberOfLogins(int $numberOfLogins): self
    {
        $this->numberOfLogins = $numberOfLogins;
        return $this;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

    public function getRoles()
    {
        $roles = [
            'ROLE_USER'
        ];
        if ($this->isAdmin() === true) {
            $roles[] = 'ROLE_ADMIN';
        }
        if ($this->isReadOnly() === true) {
            $roles[] = 'ROLE_READ_ONLY';
        }
        return $roles;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin = true): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(bool $readOnly = true): self
    {
        $this->readOnly = $readOnly;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return;
    }

    public function getSettings(): UserSetting
    {
        return $this->settings;
    }

    public function setSettings(UserSetting $settings): self
    {
        $settings->setUser($this);
        $this->settings = $settings;
        return $this;
    }
}
