<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Helper\DateTimeHelper;
use App\Message\RegisterMessage;
use App\Repository\ResultRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_')]
final class IndexController extends AbstractController
{

    public function __construct(
            private ResultRepository $resultRepository,
            private LoggerInterface $looger
    )
    {
        
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->dias(1);
    }

    #[Route('/dias/{dias}', name: 'dias', defaults: ['day' => 1], methods: ['GET'])]
    public function dias(int $dias): Response
    {
        return $this->render('index/index.html.twig', ['dias' => $dias]);
    }

    #[Route('/json/dias', name: 'json_dias', methods: ['POST'])]
    public function jsonDias(Request $request): JsonResponse
    {
        $dias = intval($request->request->get('dias'));

        return $this->json([
                    'message' => 'success',
                    'result' => $this->resultRepository->findByDias($dias)
        ]);
    }

    #[Route('/json/detalhe', name: 'json_detalhe', methods: ['POST'])]
    public function jsonDetalhe(Request $request): JsonResponse
    {
        $dias = intval($request->attributes->get('dias'));

        return $this->json([
                    'message' => 'success',
                    'result' => $this->resultRepository->findByDias($dias)
        ]);
    }

    #[Route('/medir', name: 'medir')]
    public function medir(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new RegisterMessage());

        return $this->render('index/medir.html.twig', [
                    'controller_name' => DateTimeHelper::dateTimeToString(),
        ]);
    }
}
