<?php


namespace App\Service\Normalizer;


use App\Entity\Ship;
use App\Repository\Realtime\ShipRealtimeStatusRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShipPowerNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private ShipRealtimeStatusRepositoryInterface $shipStatusCache;

    /**
     * ShipPowerNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param ShipRealtimeStatusRepositoryInterface $shipStatusCache
     */
    public function __construct(ObjectNormalizer $normalizer, ShipRealtimeStatusRepositoryInterface $shipStatusCache)
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
        /** @var array $data */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['power'] = $this->getPower($object);

        return $data;
    }

    private function getPower(Ship $ship): float
    {
        $status = $this->shipStatusCache->findOneByShip($ship);

        return $status->getPower();
    }
}
