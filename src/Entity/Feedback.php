<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Category;
use App\Entity\Post;

// #[ApiResource(
//     collectionOperations: ['get'],
//     itemOperations: [],
//     paginationEnabled: false
// )]
final class Feedback
{
    // #[ApiProperty(identifier:true)] 
    private int $id;
    // #[ApiProperty(description: "This is a little feeback")] 
    // private string $description;

    public function __construct(int $id, string $description)
    {
        $this->id = $id;
        // $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of description
     */ 
    // public function getDescription()
    // {
    //     return $this->description;
    // }

    // public function setId($id): self
    // {
    //     $this->id = $id;

    //     return $this;
    // }

    /**
     * Get the value of post
     */ 
    // public function getPost(): Post
    // {
    //     return $this->post;
    // }

    /**
     * Set the value of post
     *
     * @return  self
     */ 
    // public function setPost($post): self
    // {
    //     $this->post = $post;

    //     return $this;
    // }

    /**
     * Get the value of category
     */ 
    // public function getCategory(): Category
    // {
    //     return $this->category;
    // }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    // public function setCategory($category): self
    // {
    //     $this->category = $category;

    //     return $this;
    // }
}
