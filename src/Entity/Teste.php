<?php

namespace App\Entity;

use App\Repository\TesteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TesteRepository::class)]
class Teste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $teste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeste(): ?string
    {
        return $this->teste;
    }

    public function setTeste(string $teste): self
    {
        $this->teste = $teste;

        return $this;
    }
}
