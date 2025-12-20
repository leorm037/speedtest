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
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $filter_name = $request->query->get('filter_name', null);
        $filter_location = $request->query->get('filter_location', null);
        $filter_country = $request->query->get('filter_country', null);
        $filter_host = $request->query->get('filter_host', null);
        $filter_port = $request->query->getInt('filter_port', 0);

        $registrosPorPagina = $request->query->getInt('registros-por-pagina', 10);
        $paginaAtual = $request->query->getInt('pagina', 1);

        $servers = $this->repository->list(
            $filter_name,
            $filter_location,
            $filter_country,
            $filter_host,
            $filter_port,
            $registrosPorPagina,
            $paginaAtual
        );

        return $this->render('server/index.html.twig', [
            'servers' => $servers,
            'filter_name' => $filter_name,
            'filter_location' => $filter_location,
            'filter_country' => $filter_country,
            'filter_host' => $filter_host,
            'filter_port' => $filter_port,
            'locations' => $this->repository->locations(),
            'countries' => $this->repository->countries()
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
