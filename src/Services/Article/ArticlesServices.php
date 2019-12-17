<?php


namespace App\Services\Article;


use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticlesServices extends AbstractController
{
    protected $manager;

    protected $article;

    public function __construct(EntityManagerInterface $manager, Article $article = null)
    {
        $this->manager = $manager;
        $this->article = $article;
    }


    public function formCreate(Request $request, Article $article) {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $this->formValidation($article);
            $form = true;
            return $form;
        }
        return $form;
    }

    public function formValidation($article) {

        $this->manager->persist($article);
        $this->manager->flush();


    }
}