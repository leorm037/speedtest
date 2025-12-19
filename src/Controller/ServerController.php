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

use App\Entity\Server;
use App\Form\ServerFilterFormType;
use App\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/server', name: 'app_server_')]
final class ServerController extends AbstractController
{

    public function __construct(
            private ServerRepository $repository,
    )
    {
        
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $serverFilter = new Server();

        $form = $this->createForm(ServerFilterFormType::class, $serverFilter);
        $form->handleRequest($request);

        return $this->render('server/index.html.twig', [
                    'servers' => $this->repository->list($serverFilter),
                    'form' => $form
        ]);
    }

    #[Route('/selected', name: 'selected')]
    public function selected(Request $request): JsonResponse
    {
        $id = $request->request->get('id', null);

        $selected = ('true' === $request->request->get('selected')) ? true : false;

        if (null === $id) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }

        $this->repository->saveSelected($id, $selected);

        return $this->json(null, Response::HTTP_OK);
    }
}
