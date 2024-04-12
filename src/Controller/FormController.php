<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormController extends AbstractController
{
    #[Route('/form/new', name: 'new_form')]
    public function new(Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $em): Response
    {
        $article = new Article();
        $article->setTitle('Hello world');
        $article->setContent('Un très court article.');
        $article->setAuthor('Zozor');
        $article->setDate(new \DateTime());

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
        }

        return $this->render('new/index.html.twig', array(
            'form' => $form->createView(),
        ));

//        dd($request);

//        $validator = Validation::createValidator();
//        $violations = $validator->validate($article->getContent(), [
//            new Length(['min' => 10]),
//            new NotBlank(),
//        ]);
//
//        if (0 != count($violations)) {
//            foreach ($violations as $violation) {
//                echo $violation->getMessage(). '<br>';
//            }
//        }
//
//        $errors = $validator->validate($article);
//
//        if (count($errors) > 0) {
//            $errorsString = (string)$errors;
//
//            return new Response($errorsString);
//        }

    }

    #[Route('/form/edit/{id}')]
    public function edit(Request $request, Article $article, EntityManagerInterface $em, int $id)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

//        $search = $em->getRepository(Article::class)->find($id);
//        $search = $em->getRepository(Article::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }

        return $this->render('new/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    #[Route('/form/delete/{id<\d+>}')]
    public function delete(Request $request, Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('new_form');
    }
}
