<?php

namespace App\Controller;

use App\Repository\SpeedtestServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/speedtest/server', name: 'app_speedtest_server_')]
class SpeedtestServerController extends AbstractController
{

    private SpeedtestServerRepository $speedtestServerRepository;

    public function __construct(SpeedtestServerRepository $speedtestServerRepository)
    {
        $this->speedtestServerRepository = $speedtestServerRepository;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $sort = $request->get('sort');
        $order = $request->get('order');
        
        $list = $this->speedtestServerRepository->list($sort, $order);
        
        return $this->render('speedtest_server/index.html.twig', compact('list'));
    }

    #[Route('/edit', name: 'edit', methods: ['POST'])]
    public function edit(Request $request): JsonResponse
    {

        $id = intval($request->get('id'));

        $selected = ("true" === $request->get('selected')) ? true : false;
        
        if (null === $id) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }

        $speedtestServer = $this->speedtestServerRepository->saveSelected($id, $selected);

        return $this->json($speedtestServer, Response::HTTP_OK);
    }

}
