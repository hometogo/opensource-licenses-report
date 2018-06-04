<?php

namespace HomeToGo\License\Parser;

use HomeToGo\License\Dependency;
use HomeToGo\License\Parser\Composer\JsonParser;

class ParserFactory
{

    const POS_PROJECT = 0;
    const POS_TYPE = 1;
    const POS_ENV = 2;

    const TYPE_COMPOSER = 'composer';

    /**
     * @param string $file
     * @return ParserInterface
     */
    public function getParser($file)
    {
        $type = $this->parseFileName($file, self::POS_TYPE);

        switch ($type) {
            case self::TYPE_COMPOSER:
                return new JsonParser();
                break;
        }

        throw new UnknownFileFormatException('Unsupported file format %s', $file);
    }

    /**
     * @param string $file
     * @param int $pos
     * @return string
     */
    public function parseFileName($file, $pos = self::POS_PROJECT)
    {
        $name = basename($file);
        // myproject.composer.dev.json
        $parts = explode('.', $name);

        if (count($parts) !== 4) {
            throw new UnknownFileFormatException(
                'Unsupported name. Expected name like myproject.composer.dev.json'
            );
        }

        $env = [Dependency::ENV_PROD, Dependency::ENV_DEV];
        if (!in_array($parts[self::POS_ENV], $env)) {
            throw new UnknownFileFormatException(
                'Unsupported env %s, expected one of: %s',
                $parts[self::POS_ENV],
                join(',', $env)
            );
        }

        return $parts[$pos];
    }
}
