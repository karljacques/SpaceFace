<?php


namespace App\Controller\Authentication;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SecurityController extends AbstractController
{
    private UserProviderInterface $userProvider;
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * SecurityController constructor.
     * @param UserProviderInterface $userProvider
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserProviderInterface $userProvider, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userProvider = $userProvider;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $username = $request->get('username');
        $password = $request->get('password');

        /** @var User|null $user */
        $user = $this->userProvider->loadUserByUsername($username);

        if (null === $user) {
            return $this->invalidCredentialsResponse();
        }

        $passwordValid = $this->passwordEncoder->isPasswordValid($user, $password);

        if ($passwordValid) {
            return $this->json([
                'success' => true,
                'token' => $user->getApiToken()
            ]);
        }

        return $this->invalidCredentialsResponse();
    }

    protected function invalidCredentialsResponse(): JsonResponse
    {
        return $this->json([
            'success' => false,
            'error' => 'Invalid credentials'
        ]);
    }
}
