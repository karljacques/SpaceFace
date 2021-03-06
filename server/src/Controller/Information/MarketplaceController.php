<?php


namespace App\Controller\Information;


use App\Entity\Ship;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MarketplaceController extends AbstractController
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/economy/markets", methods={"GET"})
     */
    public function index()
    {
        /** @var User $user */
        $user = $this->security->getUser();
        /** @var Ship $ship */
        $ship = $user->getCharacters()->first()->getShips()->first();

        $dockable = $ship->getDockedAt();

        if ($dockable) {
            $markets = $dockable->getMarkets();
        } else {
            $markets = [];
        }

        return $this->json([
            'data' => [
                'markets' => $markets
            ]
        ], 200, [], ['groups' => ['basic']]);
    }
}
