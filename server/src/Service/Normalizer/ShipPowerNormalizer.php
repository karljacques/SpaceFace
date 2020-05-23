<?php


namespace App\Service\Normalizer;


use App\Entity\Ship;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Cache\CacheInterface;

class ShipPowerNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    /** Delete Me **/
    private CacheInterface $cache;

    /**
     * ShipPowerNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param CacheInterface $cache
     */
    public function __construct(ObjectNormalizer $normalizer, CacheInterface $cache)
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
        return $this->cache->get(sprintf('ship_%s_power', $ship->getId()), function () use ($ship) {
            return $ship->getMaxPower();
        });
    }
}
