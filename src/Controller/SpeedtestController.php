<?php

namespace App\Controller;

use App\Repository\SpeedtestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SpeedtestController extends AbstractController
{

    private SpeedtestRepository $speedtestRepository;

    public function __construct(SpeedtestRepository $speedtestRepository)
    {
        $this->speedtestRepository = $speedtestRepository;
    }

    public function index(): Response
    {
        return $this->days(1);
    }

    public function days(int $days): Response
    {
        return $this->render('speedtest/index.html.twig', [
                    'days' => $days
        ]);
    }

    public function jsonDays(int $days): JsonResponse
    {
        return $this->json([
                    'message' => 'success',
                    'result' => $this->speedtestRepository->findByDays($days)
        ]);
    }

}
