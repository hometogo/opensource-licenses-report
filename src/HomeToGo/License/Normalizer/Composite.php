<?php

namespace HomeToGo\License\Normalizer;

class Composite implements NormalizerInterface
{

    /**
     * @var NormalizerInterface[]
     */
    private $normalisers = [];

    /**
     * @param NormalizerInterface $normaliser
     * @return $this
     */
    public function addNormaliser(NormalizerInterface $normaliser)
    {
        $this->normalisers[] = $normaliser;
        return $this;
    }

    /**
     * @param string $license
     * @return string
     */
    public function normalize($license)
    {
        foreach ($this->normalisers as $normaliser) {
            $license = $normaliser->normalize($license);
        }

        return $license;
    }
}
