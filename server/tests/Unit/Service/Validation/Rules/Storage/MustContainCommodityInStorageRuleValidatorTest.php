<?php

namespace App\Tests\Unit\Service\Validation\Rules\Storage;

use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Repository\Join\StoredCommodityRepository;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;
use Prophecy\Prophecy\ObjectProphecy;

class MustContainCommodityInStorageRuleValidatorTest extends AbstractRuleValidator
{
    protected ObjectProphecy $storedCommodityRepository;

    public function setUp(): void
    {
        $this->storedCommodityRepository = $this->prophesize(StoredCommodityRepository::class);

        $this->validator = new MustContainCommodityInStorageRuleValidator($this->storedCommodityRepository->reveal());
    }

    public function testValidateCommodityInStorage()
    {
        $storage = new Storage();
        $commodity = new Commodity();
        $quantity = 1;

        $rule = new MustContainCommodityInStorageRule($storage, $commodity, $quantity);

        $this->storedCommodityRepository->doesStorageContainCommodity($storage, $commodity, $quantity)
            ->willReturn(true);

        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateCommodityNotInStorage()
    {
        $storage = new Storage();
        $commodity = new Commodity();
        $quantity = 1;

        $rule = new MustContainCommodityInStorageRule($storage, $commodity, $quantity);

        $this->storedCommodityRepository->doesStorageContainCommodity($storage, $commodity, $quantity)
            ->willReturn(false);

        $this->assertFalse($this->validator->validate($rule));
    }
}
