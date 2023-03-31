<?php

namespace App\Entity;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\State\UserStateProcessor;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity (repositoryClass=UserRepository::class)
 * @UniqueEntity (fields={"username"})
 * @UniqueEntity (fields={"email"})
 */
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    operations: [
        new Get(),
        new Put(),
        new Delete(),
        new GetCollection(),
        new Post(
            processor: UserStateProcessor::class,
            validationContext: [
                'groups' => ['Default', 'create']
            ]
        )
    ],
)]
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;
    /**
     * This field will not be persisted
     * to Doctrine: it exists just as a
     * temporary storage
     *
     * @Groups({"user:write"})
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     */
    private $plainPassword;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $username;
    public function getId() : ?int
    {
        return $this->id;
    }
    public function getEmail() : ?string
    {
        return $this->email;
    }
    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername() : string
    {
        return (string) $this->username;
    }
    /**
     * @see UserInterface
     */
    public function getRoles() : array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;
        return $this;
    }
    public function getPlainPassword() : ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $password) : self
    {
        $this->plainPassword = $password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword() : string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password) : self
    {
        $this->password = $password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt() : void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials() : void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function setUsername(string $username) : self
    {
        $this->username = $username;
        return $this;
    }
}
