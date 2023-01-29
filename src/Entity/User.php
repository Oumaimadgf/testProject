<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @method string getUserIdentifier()
 */
class User implements UserInterface,\Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable= false)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project" ,mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $projects;

    /**
     * @ORM\Column(type="json")
     *
     */
    private $roles = [];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
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
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function serialize()
    {
     return serialize([

         $this->id,
         $this->username,
         $this->password,


     ]);
    }

    public function unserialize($serialized)
    {
       list(
           $this->id,
           $this->username,
           $this->password,
           ) =  unserialize($serialized,['allowed_classes' => false]);
    }
}
