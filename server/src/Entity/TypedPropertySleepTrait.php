<?php


namespace App\Entity;


trait TypedPropertySleepTrait
{
    public function __sleep()
    {
        return [];
    }
}
