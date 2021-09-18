<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostCountController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $req): int
    {
        $onlineQuery = $req->get('online');
        
        $conditions=[];
        if( null !== $onlineQuery ) {
            $conditions = ['online' => ( '1' === $onlineQuery ) ? true : false];
        }


        return $this->postRepository->count($conditions);
    }
}
