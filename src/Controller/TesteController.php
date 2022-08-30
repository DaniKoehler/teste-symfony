<?php

namespace App\Controller;

use App\Entity\Teste;
use App\Form\TesteType;
use App\Repository\TesteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teste')]
class TesteController extends AbstractController
{
    #[Route('/', name: 'app_teste_index', methods: ['GET'])]
    public function index(TesteRepository $testeRepository): Response
    {
        return $this->render('teste/index.html.twig', [
            'testes' => $testeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TesteRepository $testeRepository): Response
    {
        $teste = new Teste();
        $form = $this->createForm(TesteType::class, $teste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testeRepository->add($teste, true);

            return $this->redirectToRoute('app_teste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teste/new.html.twig', [
            'teste' => $teste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teste_show', methods: ['GET'])]
    public function show(Teste $teste): Response
    {
        return $this->render('teste/show.html.twig', [
            'teste' => $teste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teste $teste, TesteRepository $testeRepository): Response
    {
        $form = $this->createForm(TesteType::class, $teste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testeRepository->add($teste, true);

            return $this->redirectToRoute('app_teste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teste/edit.html.twig', [
            'teste' => $teste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teste_delete', methods: ['POST'])]
    public function delete(Request $request, Teste $teste, TesteRepository $testeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teste->getId(), $request->request->get('_token'))) {
            $testeRepository->remove($teste, true);
        }

        return $this->redirectToRoute('app_teste_index', [], Response::HTTP_SEE_OTHER);
    }
}
