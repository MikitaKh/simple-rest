<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource as ResourceApi;
use App\Repository\POSTRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Operations;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: POSTRepository::class)]
#[ApiResource(
       operations:[
        new Get(
            uriTemplate:'/posts/{id}'
        ),
        new GetCollection(
            uriTemplate:'/posts'
        )
       ],
       paginationEnabled: false,
    )]
class POST
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    //#[Groups(['post:list', 'post:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    //#[Groups(['post:list', 'post:item'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    //#[Groups(['post:list', 'post:item'])]
    private ?string $article = null;

    #[ORM\Column(length: 255)]
    //#[Groups(['post:list', 'post:item'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
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

    
}
