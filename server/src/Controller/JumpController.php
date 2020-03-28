<?php


namespace App\Controller;


use App\Command\JumpCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JumpController extends AbstractController
{
    public function index(JumpCommand $command)
    {
        dump($command);

        return $this->json(['yo']);
    }
}
