<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Services\Article\ArticlesServices;
use App\Services\Article\CommentServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig', ['age' => 18, 'title' => 'Bienvenue les amis']);
    }

    /**
     * @Route("blog/new", name="blog_create")
     * @Route("blog/{id}/edit", name="blog_edit")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function form(ArticlesServices $articlesServices, Request $request,Article $article = null) {
             if (!$article) {
                $article = new Article();
            }
            $form = $articlesServices->formCreate($request, $article);
            if ($form === true) {

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        return $this->render('blog/create.html.twig',
                ['formArticle' => $form->createView(),
                  'editMode' => $article->getId() !== null ]);
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function show(Article $article,Request $request ,CommentServices $commentServices) {
        $comment = new Comment();
        $form = $commentServices->formCreate($article, $request, $comment);
            if ($form === true) {

                return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
            }
        return $this->render('blog/show.html.twig', ['article' => $article, 'formComment' => $form->createView()]);
    }
}
