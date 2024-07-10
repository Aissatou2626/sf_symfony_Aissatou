<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\CategorieRepository;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\HasLifecycleCallbacks] 
class Categorie
{
    use EnableTrait, 
        DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
