<?php


namespace App\Service\Validator\Rules;


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

    public function validate(): bool
    {
        $system = $this->location->getSystem();

        return $system->getBoundingBox()->containsPoint($this->location->getVector());
    }
}
