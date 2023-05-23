<?php

namespace App\Controller;

use App\Repository\SpeedtestRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function dd;

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

    public function jsonDays(Request $request): JsonResponse
    {
        $days = intval($request->get('days'));
        
        return $this->json([
                    'message' => 'success',
                    'result' => $this->speedtestRepository->findByDays($days)
        ]);
    }

    public function jsonDetail(Request $request): JsonResponse
    {
        $dateTimeString = $request->get('dateTime');
        
        $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $dateTimeString, new DateTimeZone('America/Sao_Paulo'));
        $dateTime->setTimezone(new \DateTimeZone('UTC'));

        return $this->json([
                    'message' => 'success',
                    'speedtest' => $this->speedtestRepository->findByDateTime($dateTime)
        ]);
    }

}
