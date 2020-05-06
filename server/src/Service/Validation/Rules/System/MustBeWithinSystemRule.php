<?php


namespace App\Service\Validation\Rules\System;


use App\Service\Validation\Rules\RuleInterface;
use App\Util\Location;

class MustBeWithinSystemRule implements RuleInterface
{
    /**
     * @var Location
     */
    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function getViolationMessage(): string
    {
        return 'Proposed location is out of system bounds';
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }
}
