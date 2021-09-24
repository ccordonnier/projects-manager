<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="owner")
     */
    private $projectsCreated;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="users")
     */
    private $inProjects;

    public function __construct()
    {
        $this->projectsCreated = new ArrayCollection();
        $this->inProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): self
    {
        $this->profil = $profil;

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

    /**
     * @return Collection|Project[]
     */
    public function getProjectsCreated(): Collection
    {
        return $this->projectsCreated;
    }

    public function addProjectsCreated(Project $projectsCreated): self
    {
        if (!$this->projectsCreated->contains($projectsCreated)) {
            $this->projectsCreated[] = $projectsCreated;
            $projectsCreated->setOwner($this);
        }

        return $this;
    }

    public function removeProjectsCreated(Project $projectsCreated): self
    {
        if ($this->projectsCreated->removeElement($projectsCreated)) {
            // set the owning side to null (unless already changed)
            if ($projectsCreated->getOwner() === $this) {
                $projectsCreated->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getInProjects(): Collection
    {
        return $this->inProjects;
    }

    public function addInProject(Project $inProject): self
    {
        if (!$this->inProjects->contains($inProject)) {
            $this->inProjects[] = $inProject;
            $inProject->addUser($this);
        }

        return $this;
    }

    public function removeInProject(Project $inProject): self
    {
        if ($this->inProjects->removeElement($inProject)) {
            $inProject->removeUser($this);
        }

        return $this;
    }
}
