<?php

namespace App\Controller\Post;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="list_posts")
     *
     * @throws \Exception
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);

        // TODO add filtering, sorting and pagination
        $posts = $repo->findAll();

        // TODO increase limit of dotted symbols
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
            // TODO find better solution in twig
            'currentDate' => new DateTime(),
        ]);
    }

    /**
     * @Route("/create", name="create_post")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        // TODO add real user
        $author = $this->getDoctrine()->getRepository(User::class)->findOneById(1);

        $post = new Post();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create post'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $post->setCreateAt(new DateTime())
                ->setActiveStatus()
                ->setAuthor($author);

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('list_posts');
        }

        return $this->render('posts/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_post")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function view(Post $post, Request $request)
    {
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findAllByPostId($post->getId());


        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('author', TextType::class, ['label' => 'Name'])
            ->add('email', EmailType::class)
            ->add('url', TextType::class)
            ->add('body', TextareaType::class, ['label' => 'Comment'])
            ->add('save', SubmitType::class, ['label' => 'Create comment'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $comment->setPost($post)
                ->setCreateAt(new DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('detail_post', ['id' => $post->getId()]);
        }


        return $this->render('posts/detail.html.twig', [
            'post' => $post,
            // TODO find better solution in twig
            'currentDate' => new DateTime(),
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}
