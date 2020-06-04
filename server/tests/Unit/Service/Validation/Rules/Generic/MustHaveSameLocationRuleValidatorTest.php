<?php

namespace App\Tests\Unit\Service\Validation\Rules\Generic;

use App\Entity\Dockable;
use App\Entity\Ship;
use App\Entity\System;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRuleValidator;
use App\Tests\Helpers\LocationHelper;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;
use App\Util\Location;
use App\Util\Vector2;

class MustHaveSameLocationRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustHaveSameLocationRuleValidator();
    }

    public function testValidateSameLocation()
    {
        $ship = new Ship();
        $dockable = new Dockable();

        $location = $this->getLocation();

        $ship->setLocation($location);
        $dockable->setLocation($location);

        $rule = new MustHaveSameLocationRule($ship, $dockable);

        $this->assertTrue($this->validator->validate($rule));
    }

    /**
     * @return Location
     */
    protected function getLocation(): Location
    {
        $system = new System();
        $system->setId(1);

        return new Location($system, new Vector2(1, 1));
    }

    public function testValidateDifferentLocation()
    {
        $ship = new Ship();
        $dockable = new Dockable();

        $location = $this->getLocation();

        $ship->setLocation($location);
        $dockable->setLocation(LocationHelper::offsetLocation($location));

        $rule = new MustHaveSameLocationRule($ship, $dockable);

        $this->assertFalse($this->validator->validate($rule));
    }
}
