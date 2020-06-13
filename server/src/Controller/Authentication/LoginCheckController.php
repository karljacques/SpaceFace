<?php


namespace App\Controller\Authentication;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LoginCheckController extends AbstractController
{
    /**
     * @Route("/authenticated")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'authenticated' => $this->getUser() !== null
        ]);
    }
}
