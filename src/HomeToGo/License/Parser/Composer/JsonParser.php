<?php

namespace HomeToGo\License\Parser\Composer;

use HomeToGo\License\Dependency;
use HomeToGo\License\Parser\ParserInterface;

class JsonParser implements ParserInterface
{

    /**
     * @param string $filename
     * @return Dependency[]
     */
    public function parse($filename)
    {
        $out = [];
        $data = json_decode(file_get_contents($filename), true);

        foreach ($data['dependencies'] as $name => $license) {
            $out[] = new Dependency(
                $name,
                join(',', $license['license']),
                sprintf('https://packagist.org/packages/%s', $name),
                'PHP',
                [
                    $data['name'] => $license['version']
                ]
            );
        }

        return $out;
    }
}
