<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: ModulesDetails::class, orphanRemoval: true)]
    private Collection $modulesDetails;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function __construct()
    {
        $this->modulesDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, ModulesDetails>
     */
    public function getModulesDetails(): Collection
    {
        return $this->modulesDetails;
    }

    public function addModulesDetail(ModulesDetails $modulesDetail): self
    {
        if (!$this->modulesDetails->contains($modulesDetail)) {
            $this->modulesDetails->add($modulesDetail);
            $modulesDetail->setModule($this);
        }

        return $this;
    }

    public function removeModulesDetail(ModulesDetails $modulesDetail): self
    {
        if ($this->modulesDetails->removeElement($modulesDetail)) {
            // set the owning side to null (unless already changed)
            if ($modulesDetail->getModule() === $this) {
                $modulesDetail->setModule(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
