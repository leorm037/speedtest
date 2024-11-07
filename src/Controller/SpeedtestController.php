<?php

namespace App\Controller;

use App\Repository\SpeedtestRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_speedtest_')]
class SpeedtestController extends AbstractController
{

    private SpeedtestRepository $speedtestRepository;

    public function __construct(SpeedtestRepository $speedtestRepository)
    {
        $this->speedtestRepository = $speedtestRepository;
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->days(1);
    }

    #[Route(
                path: ['pt_BR' => '/{_locale}/dias/{days}', 'en' => '/{_locale}/days/{days}'],
                name: 'days',
                methods: ['GET'],
                defaults: ['_locale' => 'pt_BR', 'days' => 1],
                requirements: ['_locale' => 'en|pt_BR']
        )]
    public function days(int $days): Response
    {
        return $this->render('speedtest/index.html.twig', [
                    'days' => $days
        ]);
    }

    #[Route('/json/days', name: 'json_days', methods: ['POST'])]
    public function jsonDays(Request $request): JsonResponse
    {
        $days = intval($request->get('days'));

        return $this->json([
                    'message' => 'success',
                    'result' => $this->speedtestRepository->findByDays($days)
        ]);
    }

    #[Route('/json/detail', name: 'json_detail', methods: ['POST'])]
    public function jsonDetail(Request $request): JsonResponse
    {
        $dateTimeString = $request->get('dateTime');

        $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $dateTimeString, new DateTimeZone('America/Sao_Paulo'));
        $dateTime->setTimezone(new \DateTimeZone('UTC'));

        $speedtest = $this->speedtestRepository->findByDateTime($dateTime);

        return $this->json([
                    'message' => 'success',
                    'speedtest' => $speedtest
        ]);
    }
}
