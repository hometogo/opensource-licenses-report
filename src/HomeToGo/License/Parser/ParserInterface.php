<?php

namespace HomeToGo\License\Parser;

use HomeToGo\License\Dependency;

interface ParserInterface
{

    /**
     * @param string $filename
     * @return Dependency[]
     */
    public function parse($filename);
}
