<?php


namespace App\Controller;


use App\Command\JumpCommand;

class JumpController extends AbstractCommandController
{
    public function index()
    {
        $command = $this->createCommand(JumpCommand::class);

        dump($command);

        return $this->json([

        ]);
    }
}
