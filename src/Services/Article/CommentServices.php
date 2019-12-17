<?php


namespace App\Services\Article;


use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CommentServices extends AbstractController
{

    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function formCreate(Article $article,Request $request,Comment $comment) {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                ->setArticle($article);
            $this->formValidation($comment);
            $form = true;
            return $form;
        }
        return $form;
    }

    public function formValidation($comment) {
            $this->manager->persist($comment);
            $this->manager->flush();
    }
}