<?php


namespace App\Service\Normalizer;


use App\Entity\Ship;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShipPowerNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private CacheItemPoolInterface $cache;

    /**
     * ShipPowerNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(ObjectNormalizer $normalizer, CacheItemPoolInterface $cache)
    {
        $this->normalizer = $normalizer;
        $this->cache = $cache;
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
        $cacheItem = $this->cache->getItem(sprintf('ship_%s_power', $ship->getId()));

        return $cacheItem->isHit() ? $cacheItem->get() : $ship->getMaxPower();
    }
}
