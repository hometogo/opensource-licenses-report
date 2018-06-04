<?php

namespace HomeToGo\License\Parser\Yarn;

use HomeToGo\License\Dependency;
use HomeToGo\License\Parser\ParserFactory;
use HomeToGo\License\Parser\ParserInterface;

class JsonParser implements ParserInterface
{
    /**
     * @param string $filename
     * @return Dependency[]
     */
    public function parse($filename)
    {
        $output = [];

        $project = (new ParserFactory())->parseFileName($filename, ParserFactory::POS_PROJECT);

        $handle = fopen($filename, 'r');
        while (($line = fgets($handle)) !== false) {
            $data = json_decode($line, true);

            if ($data['type'] === 'table') {
                foreach ($data['data']['body'] as $row) {
                    $output[] = new Dependency(
                        $row[0],
                        $row[2],
                        sprintf('https://yarn.pm/%s', $row[0]),
                        Dependency::TYPE_JS,
                        [
                            $project => $row[1]
                        ]
                    );
                }
            }
        }

        fclose($handle);

        return $output;
    }
}
