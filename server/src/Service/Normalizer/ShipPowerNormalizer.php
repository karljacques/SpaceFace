<?php


namespace App\Service\Normalizer;


use App\Entity\Ship;
use App\Service\ShipStatusCache;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShipPowerNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    /** Delete Me **/
    private ShipStatusCache $shipStatusCache;

    /**
     * ShipPowerNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param ShipStatusCache $shipStatusCache
     */
    public function __construct(ObjectNormalizer $normalizer, ShipStatusCache $shipStatusCache)
    {
        $this->normalizer = $normalizer;
        $this->shipStatusCache = $shipStatusCache;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Ship;
    }

    /**
     * @param $object Ship
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['power'] = $this->getPower($object);

        return $data;
    }

    private function getPower(Ship $ship): int
    {
        $item = $this->shipStatusCache->getShipStatus($ship);

        return $item->get()->getPower();
    }
}
