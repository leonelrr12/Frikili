<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    const REGISTRO_EXITOSO = 'Se ha registrado exitosamente.';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $baneado;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Comentarios::class, mappedBy="user")
     */
    private $Comentarios;

    /**
     * @ORM\OneToMany(targetEntity=Profesion::class, mappedBy="user")
     */
    private $Profesion;

    /**
     * @ORM\OneToMany(targetEntity=Posts::class, mappedBy="user")
     */
    private $Posts;

    public function __construct()
    {
        $this->Comentarios = new ArrayCollection();
        $this->Profesion = new ArrayCollection();
        $this->Posts = new ArrayCollection();
        $this->baneado = false;
        $this->roles = ['ROLE_USER'];
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBaneado(): bool
    {
        return $this->baneado;
    }

    /**
     * @param bool $baneado
     */
    public function setBaneado(bool $baneado): void
    {
        $this->baneado = $baneado;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Comentarios[]
     */
    public function getComentarios(): Collection
    {
        return $this->Comentarios;
    }

    public function addComentario(Comentarios $comentario): self
    {
        if (!$this->Comentarios->contains($comentario)) {
            $this->Comentarios[] = $comentario;
            $comentario->setUser($this);
        }

        return $this;
    }

    public function removeComentario(Comentarios $comentario): self
    {
        if ($this->Comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getUser() === $this) {
                $comentario->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Profesion[]
     */
    public function getProfesion(): Collection
    {
        return $this->Profesion;
    }

    public function addProfesion(Profesion $profesion): self
    {
        if (!$this->Profesion->contains($profesion)) {
            $this->Profesion[] = $profesion;
            $profesion->setUser($this);
        }

        return $this;
    }

    public function removeProfesion(Profesion $profesion): self
    {
        if ($this->Profesion->removeElement($profesion)) {
            // set the owning side to null (unless already changed)
            if ($profesion->getUser() === $this) {
                $profesion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Posts[]
     */
    public function getPosts(): Collection
    {
        return $this->Posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->Posts->contains($post)) {
            $this->Posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->Posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }
}
