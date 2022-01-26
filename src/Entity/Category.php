<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ApiResource()
 */

#[ApiResource(
    collectionOperations: [
        'get' => [
            "pagination_enabled" => true, 
            "pagination_client_items_per_page"=>true,
            "pagination_items_per_page"=>1, 
            "maximum_items_per_page"=>5, 
            // 'pagination_enabled' => true,
            // 'pagination_maximum_items_per_page' => 1,
        ], 
        'post',
        'special' => [
            'method' => 'POST',
            'path' => '/categories/special',
            'denormalization_context' => ['groups' => ['special:Category']],
            'normalization_context' => ['groups' => ['special:Category']],
        ]
    ],
    itemOperations: ['put', 'patch', 'delete', 'get' => [
        'controller' => NotFoundAction::class,
        'openapi_context' => [
            'summary' => 'hidden'
        ],
        'read' => false,
        'output' => false
    ]]
)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:Post", "special:Category"})
     */
    #[ApiProperty(identifier: true)]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:Post", "write:Post", "special:Category"})
     * @Assert\Length(min = 3)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="category")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

        return $this;
    }
}
