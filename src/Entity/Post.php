<?php

namespace App\Entity;

use DateTime;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;

use App\Controller\PostCountController;
use App\Controller\PostPublishController;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource(
 *       attributes={"pagination_items_per_page"=2, "maximum_items_per_page"=2, "pagination_client_items_per_page"=true},
 *       normalizationContext={"groups"={"read:collection"}, "openapi_definition_name"="Collection"},
 *       denormalizationContext={"groups"={"write:Post"}},
 *       collectionOperations={
 *          "get",
 *          "post",
 *       },
 *       itemOperations={
 *         "put",
 *         "delete",
 *         "get"={
 *              "normalization_context"={"groups"={"read:collection", "read:item", "read:Post"}, "openapi_definition_name"="Detail"}
 *          },
 *         "publish"={
 *             "method": "POST",
 *             "path": "/posts/{id}/publish",
 *             "controller": PostPublishController::class,
 *             "openapi_context"={
 *                  "summary"="Permet de publier un article",
 *                  "requestBody"={
 *                      "content"={
 *                          "application/json"={
 *                              "schema"={}
 *                          }
 *                      }
 *                  }
 *             }
 *          }
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class, properties={"id": "DESC", "title": "DESC"}, arguments={"orderParameterName"="order"}
 * )
 */

 
#[ApiResource(
    collectionOperations: [
        'count' => [
            'method' => 'GET',
            'path'   => 'posts/count',
            'controller' => PostCountController::class,
            'read' => false,
            'pagination_enabled' => false,
            'filters' => [],
            'openapi_context' => [
                'summary' => 'Récupère le nombre total d\'articles',
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'online',
                        'schema' => [
                            'type' => 'integer',
                            'maximum' => 1,
                            'minimum' => 0
                        ],
                        'description' => 'Filtre les articles en ligne'
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'integer',
                                    'exemple' => 3
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
)]

class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection", "write:Post"})
     * @Assert\Length(min = 5)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection", "write:Post"})
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:item", "write:Post"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts", cascade={"persist"})
     * @Groups({"read:item", "write:Post"})
     * @Assert\Valid
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     * @Groups({"read:collection"})
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="boolean",
     *             "description"="En ligne ou pas ?"
     *         }
     *     }
     * )
     */
    private $online = false;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public static function validationGroups(self $post)
    {
        return [
            'create:Post'
        ];
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

}
