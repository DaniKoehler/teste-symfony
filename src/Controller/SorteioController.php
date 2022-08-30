<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SorteioController extends AbstractController
{
    #[Route('/sorteio', name: 'app_sorteio')]
    public function index(Request $request): JsonResponse
    {
        $numberOne = $request->get('num1');
        $numberTwo = $request->get('num2');

        if(! ((float)$numberOne and (float)$numberTwo != '')) {
            
            return new JsonResponse([
                'Erro'=> 'Digite dois valores entre 0.00++1 e 1000000000000000000.00',
            ]);
        } 
        
        $sortedNumber = rand($numberOne, $numberTwo);

        return new JsonResponse([
            'success' => true,
            'sortedNumber' => $sortedNumber
            ], 200);
    }
}
