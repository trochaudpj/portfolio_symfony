<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $role_id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public $confirm_password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $security;

    /**
     * @ORM\ManyToOne(targetEntity=Roles::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_key;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_banned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_dead;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banned_raison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastvisit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $time_session;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $register_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $forced_avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $view_vcard;

    /**
     * @ORM\Column(type="boolean")
     */
    private $view_qrcode;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $timezone;

    /**
     * @ORM\OneToOne(targetEntity=Customer::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    public function __construct()
    {   
       // $this->role_id = '11';
        $this->is_active = false;
        $this->is_banned = false;
        $this->is_dead = false;
        $this->forced_avatar = false;
        $this->view_vcard = false;
        $this->view_qrcode = false;
        $this->plainpassword = null;
        $this->roles = ['ROLE_USER'];
        $this->locale = 'fr';
        $this->timezone = 'Europe/Paris';
        $this->lastvisit = new \DateTime();
        $this->register_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(string $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getActivationKey(): ?string
    {
        return $this->activation_key;
    }

    public function setActivationKey(?string $activation_key): self
    {
        $this->activation_key = $activation_key;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->is_banned;
    }

    public function setIsBanned(bool $is_banned): self
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    public function getIsDead(): ?bool
    {
        return $this->is_dead;
    }

    public function setIsDead(bool $is_dead): self
    {
        $this->is_dead = $is_dead;

        return $this;
    }

    public function getBannedRaison(): ?string
    {
        return $this->banned_raison;
    }

    public function setBannedRaison(?string $banned_raison): self
    {
        $this->banned_raison = $banned_raison;

        return $this;
    }

    public function getLastvisit(): ?\DateTimeInterface
    {
        return $this->lastvisit;
    }

    public function setLastvisit(\DateTimeInterface $lastvisit): self
    {
        $this->lastvisit = $lastvisit;

        return $this;
    }

    public function getTimeSession(): ?string
    {
        return $this->time_session;
    }

    public function setTimeSession(?string $time_session): self
    {
        $this->time_session = $time_session;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeInterface
    {
        return $this->register_at;
    }

    public function setRegisterAt(\DateTimeInterface $register_at): self
    {
        $this->register_at = $register_at;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getForcedAvatar(): ?bool
    {
        return $this->forced_avatar;
    }

    public function setForcedAvatar(bool $forced_avatar): self
    {
        $this->forced_avatar = $forced_avatar;

        return $this;
    }

    public function getViewVcard(): ?bool
    {
        return $this->view_vcard;
    }

    public function setViewVcard(bool $view_vcard): self
    {
        $this->view_vcard = $view_vcard;

        return $this;
    }

    public function getViewQrcode(): ?bool
    {
        return $this->view_qrcode;
    }

    public function setViewQrcode(bool $view_qrcode): self
    {
        $this->view_qrcode = $view_qrcode;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        // set the owning side of the relation if necessary
        if ($customer->getUser() !== $this) {
            $customer->setUser($this);
        }

        $this->customer = $customer;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
