<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JsonSchemaTest extends AbstractController
{
    public function index() {

        return $this->json('yo');
    }
}
