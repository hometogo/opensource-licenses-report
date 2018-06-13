<?php

namespace HomeToGo\License\Normalizer;

interface NormalizerInterface
{

    /**
     * @param string $license
     * @return string
     */
    public function normalize($license);
}
