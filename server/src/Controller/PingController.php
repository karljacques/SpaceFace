<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    /**
     * @Route("/ping", methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'data' => [
                'success' => true
            ]
        ]);
    }
}
