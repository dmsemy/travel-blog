<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Represents a user account in the system.
 */
#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     *
     * @return array<string, mixed> The serialized data
     */
    public function __serialize(): array
    {
        /** @var array<string, mixed> $data */
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password ?? '');

        return $data;
    }

    /**
     * @return int|null The account ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null The email address
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email The email address
     *
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return string The user identifier (email)
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string> The user roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    /**
     * @param list<string> $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     *
     * @return string|null The hashed password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password The hashed password
     *
     * @return $this
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }
}
