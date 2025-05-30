<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Entity\Book;
use App\Form\BookForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\FileUploader;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class ListController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function index(BookRepository $repository): Response
    {
        return $this->render('list/index.html.twig', [
            'books' => $repository->findAll(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'book_show')]
    public function show(Book $book)
    {
        return $this->render('list/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/new', name: 'book_new')]
    public function new(
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/storage')] string $dir)
    {
        $book = new Book();

        $form = $this->createForm(BookForm::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $uploader = new FileUploader($dir, $slugger);
                $book->setImageUrl($uploader->upload($image));
            }

            $manager->persist($book);
            $manager->flush();

            $this->addFlash(
                'notice',
                '成功！'
            );

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('list/new.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'book_edit')]
    public function edit(
        Book $book, 
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/storage')] string $dir): Response
    {
        $form = $this->createForm(BookForm::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $oldImageUrl = $book->getImageUrl();

                $uploader = new FileUploader($dir, $slugger);
                $book->setImageUrl($uploader->upload($image));

                if ($oldImageUrl) {
                $oldImagePath = $dir . '/' . $oldImageUrl;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            }

            $manager->flush();

            $this->addFlash(
                'notice',
                '成功呢！'
            );

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('list/edit.html.twig', [
            'form' => $form,
            'book' => $book,
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'book_delete')]
    public function delete(Request $request, Book $book, EntityManagerInterface $manager): Response {
        if ($request->isMethod('POST')) {
            $manager->remove($book);
            $manager->flush();

            $this->addFlash(
                'notice',
                '已经没有了'
            );

            return $this->redirectToRoute('book_list');
        }
        
        return $this->render('list/delete.html.twig', [
            'id' => $book->getId(),
        ]);
    }
}
