<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PingController extends AbstractController
{
    public function index()
    {
        return $this->json([
            'data' => [
                'success' => true
            ]
        ]);
    }
}
