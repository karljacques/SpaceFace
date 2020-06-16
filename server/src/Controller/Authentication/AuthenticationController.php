<?php


namespace App\Controller\Authentication;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    /**
     * @Route("/authenticated", methods={"GET"})
     */
    public function authenticated(): JsonResponse
    {
        return $this->json([
            'authenticated' => $this->getUser() !== null
        ]);
    }

    /**
     * @Route("/authentication/logout", methods={"GET"})
     * @param ParameterBagInterface $parameters
     * @return Response
     */
    public function logout(ParameterBagInterface $parameters): Response
    {
        $cookie = $parameters->get('app.authentication.jwt.cookie_name');

        $response = (new Response(null, 200));

        $response->headers->setCookie(
            new Cookie(
                $cookie,
                '',
                time() - 3600,
                '/',
                null
            )
        );

        return $response;
    }
}
