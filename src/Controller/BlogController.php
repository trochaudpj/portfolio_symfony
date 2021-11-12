<?php

namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleType;
use function Amp\Dns\query;
use App\Controller\BaseController;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends BaseController
{
	
    

	/**
	 * @Route("/blog", name="blog")
	 * @return Reponse
	 */
    public function index(ArticleRepository $articlerepository, PaginatorInterface $paginator, Request $request): Response
    {
		$articles = $articlerepository->findall();

		$articles = $paginator->paginate(
			$articles, /* query NOT result */

			$request->query->getInt('page', 1),6
		);
        return $this->template('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

	/**
	 * @Route("/bloghome", name="bloghome")
	 */
	public function bloghome(){
		return $this->template('blog/bloghome.html.twig');
	}

	/** 
	 * @Route("/blog/new", name="blog_create")
	 * @Route("/blog/{id}/edit", name="blog_edit")
	 */
	public function	form(Article $article = null, Request $request,EntityManagerInterface $entityManager){
		
		if(!$article){
			$article = new Article();
		}

		$form = $this->	createForm(ArticleType::class, $article);

		$form->handleRequest($request); 
		if($form->isSubmitted() && $form->isValid()){
			if(!$article->getId()){
				$article->setCreatedAt(new \DateTime());
			}

			$entityManager->persist($article);
			$entityManager->flush();

			return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
		}

	return $this->template('blog/create.html.twig', [
		'formArticle' => $form->createView(),
		'editMode' => $article->getId() !== null
	]);
	}

	/** 
	 * @Route("/blog/{id}", name="blog_show")  
	 */
	public function show(ArticleRepository $repo, $id){
		
		$article = $repo->find($id);
		
		if(!$repo->find($id-1)){
			$prev_article = $repo->find($id);		
		}else{
			$prev_article = $repo->find($id-1);
		}

		if(!$repo->find($id+1)){
			$next_article = $repo->find($id);		
		}else{
			$next_article = $repo->find($id+1);
		}
	
		
		return $this->template('blog/show.html.twig', [
			'article' => $article,
			'next_article' => $next_article, 
			'prev_article' => $prev_article, 
			
		]);
	} 
	
}
