<?php

namespace HomeToGo\License\Normalizer;

class Replacements implements NormalizerInterface
{

    /**
     * @var array
     */
    private $replacements = [
        'MIT License' => 'MIT',
        'Apache2' => 'Apache-2.0',
        'LGPL Version 3' => 'LGPL-3.0',
        'Apache 2' => 'Apache-2.0'
    ];

    /**
     * @param array $replacements
     * @return Replacements
     */
    public function setReplacements($replacements)
    {
        $this->replacements = $replacements;
        return $this;
    }

    /**
     * @param string $license
     * @return string
     */
    public function normalize($license)
    {
        return isset($this->replacements[$license]) ? $this->replacements[$license] : $license;
    }
}
