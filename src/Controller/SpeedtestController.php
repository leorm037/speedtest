<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SpeedtestController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('speedtest/index.html.twig');
    }

    public function days(int $days): Response
    {
        return $this->render('speedtest/index.html.twig', [
                    'days' => $days,
        ]);
    }

}
