<?php

namespace HomeToGo\License\Normalizer;

class Replacements implements NormalizerInterface
{

    const APACHE2 = 'Apache-2.0';
    const MIT = 'MIT';

    /**
     * @var array
     */
    private $replacements = [
        'MIT License' => self::MIT,
        'MIT*' => self::MIT,
        'Apache2' => self::APACHE2,
        'LGPL Version 3' => 'LGPL-3.0',
        'Apache 2' => self::APACHE2,
        'Apache, Version 2.0' => self::APACHE2,
        'Apache 2.0' => self::APACHE2,
        'ApacheV2' => self::APACHE2
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
