<?php

namespace App\Controller;

use App\Entity\Pessoa;
use App\Form\PessoaType;
use App\Repository\PessoaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pessoa')]
class PessoaController extends AbstractController
{
    #[Route('/', name: 'app_pessoa_index', methods: ['GET'])]
    public function index(PessoaRepository $pessoaRepository): Response
    {
        return $this->render('pessoa/index.html.twig', [
            'pessoas' => $pessoaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pessoa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PessoaRepository $pessoaRepository): Response
    {
        $pessoa = new Pessoa();
        $form = $this->createForm(PessoaType::class, $pessoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pessoaRepository->add($pessoa, true);

            return $this->redirectToRoute('app_pessoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pessoa/new.html.twig', [
            'pessoa' => $pessoa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pessoa_show', methods: ['GET'])]
    public function show(Pessoa $pessoa): Response
    {
        return $this->render('pessoa/show.html.twig', [
            'pessoa' => $pessoa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pessoa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pessoa $pessoa, PessoaRepository $pessoaRepository): Response
    {
        $form = $this->createForm(PessoaType::class, $pessoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pessoaRepository->add($pessoa, true);

            return $this->redirectToRoute('app_pessoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pessoa/edit.html.twig', [
            'pessoa' => $pessoa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pessoa_delete', methods: ['POST'])]
    public function delete(Request $request, Pessoa $pessoa, PessoaRepository $pessoaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pessoa->getId(), $request->request->get('_token'))) {
            $pessoaRepository->remove($pessoa, true);
        }

        return $this->redirectToRoute('app_pessoa_index', [], Response::HTTP_SEE_OTHER);
    }
}
