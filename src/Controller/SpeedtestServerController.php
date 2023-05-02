<?php

namespace App\Controller;

use App\Repository\SpeedtestServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpeedtestServerController extends AbstractController
{

    private SpeedtestServerRepository $speedtestServerRepository;

    public function __construct(SpeedtestServerRepository $speedtestServerRepository)
    {
        $this->speedtestServerRepository = $speedtestServerRepository;
    }

    public function index(): Response
    {
        $list = $this->speedtestServerRepository->list();

        return $this->render('speedtest_server/index.html.twig', compact('list'));
    }

    public function edit(Request $request): JsonResponse
    {
        $id = $request->get('id');

        $selected = $request->attributes->getBoolean('selected');

        if (null === $id) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $this->getUser();

        $speedtestServer = $this->speedtestServerRepository->saveSelected($id, $selected, $user);

        return $this->json($speedtestServer->getId(), Response::HTTP_OK);
    }

}
