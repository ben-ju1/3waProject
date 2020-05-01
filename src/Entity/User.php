<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="L'email saisie est déjà utilisé.")
 * @UniqueEntity(fields="username", message="Le nom d'utilisateur n'est pas disponible.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="Le prénom doit être renseigné.")
     * @Assert\Regex(
     *     pattern= "/^[A-Za-z\é\è\ê\-]+$/",
     *     match= true,
     *     message="Votre prénom doit seulement contenir des lettres."
     *     )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     * @Assert\Regex(
     *     pattern= "/^[A-Za-z\é\è\ê\-]+$/",
     *     match= true,
     *     message="Votre nom doit seulement contenir des lettres."
     *     )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le nom d'utilisateur doit être renseigné.")
     * @Assert\Length(
     *     min = 5,
     *     minMessage = "Votre nom d'ulitsateur doit contenir au minimum {{ limit }} caractères. ({{ value }})",
     *     max = 15,
     *     minMessage = "Votre nom d'utilisateur doit contenir au maximum {{ limit }} caractères. ({{ value }})"
     *)
     * @Assert\Regex("#^[a-zA-Z0-9]{4,15}$#", message="Le nom d'utilisateur doit contenir entre 4 et 15 caractères et ne doit contenir aucun symbole spécifique.")
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir une adresse email valide.")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas une adresse email valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$#", message="Le mot de passe doit contenir au minimum 8 caractères : 1 majuscule, 1 minuscule, 1 chiffre.")
     */
    private $password;

    /**
     * @Assert\IdenticalTo(propertyPath="password", message="Les mots de passes saisies ne correspondent pas")
     */
    private $passwordConfirm;

    /**
     * @Assert\IdenticalTo(propertyPath="newPassword", message="Les mots de passes saisies ne correspondent pas")
     */
    private $newPasswordConfirm;

    /**
     * @Assert\Regex("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$#", message="Le mot de passe doit contenir au minimum 8 caractères : 1 majuscule, 1 minuscule, 1 chiffre.")
     */
    private $newPassword;

    /**
     * @ORM\Column(name="roles", type="json")
     * @Assert\NotNull
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user")
     */
    private $tokens;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_confirmed = false;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm($passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPasswordConfirm()
    {
        return $this->newPasswordConfirm;
    }

    /**
     * @param mixed $newPasswordConfirm
     */
    public function setNewPasswordConfirm($newPasswordConfirm): void
    {
        $this->newPasswordConfirm = $newPasswordConfirm;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
    }

    /**
     * @return Collection|Token[]
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): self
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens[] = $token;
            $token->setUser($this);
        }

        return $this;
    }

    public function removeToken(Token $token): self
    {
        if ($this->tokens->contains($token)) {
            $this->tokens->removeElement($token);
            // set the owning side to null (unless already changed)
            if ($token->getUser() === $this) {
                $token->setUser(null);
            }
        }

        return $this;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->is_confirmed;
    }

    public function setIsConfirmed(bool $is_confirmed): self
    {
        $this->is_confirmed = $is_confirmed;

        return $this;
    }

}
