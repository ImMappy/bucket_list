<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=BucketList::class, mappedBy="category")
     */
    private $thingToDo;

    public function __construct()
    {
        $this->thingToDo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BucketList>
     */
    public function getThingToDo(): Collection
    {
        return $this->thingToDo;
    }

    public function addThingToDo(BucketList $thingToDo): self
    {
        if (!$this->thingToDo->contains($thingToDo)) {
            $this->thingToDo[] = $thingToDo;
            $thingToDo->setCategory($this);
        }

        return $this;
    }

    public function removeThingToDo(BucketList $thingToDo): self
    {
        if ($this->thingToDo->removeElement($thingToDo)) {
            // set the owning side to null (unless already changed)
            if ($thingToDo->getCategory() === $this) {
                $thingToDo->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getName();
    }
}
