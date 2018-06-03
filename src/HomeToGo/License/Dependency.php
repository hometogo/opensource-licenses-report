<?php

namespace HomeToGo\License;

class Dependency
{

    const TYPE_PHP = 'php';
    const TYPE_JS = 'js';

    /** @var string */
    private $name;

    /** @var string */
    private $license;

    /** @var string */
    private $link;

    /** @var string */
    private $type;

    /** @var string */
    private $project;

    /**
     * @param string $name
     * @param string $license
     * @param string $link
     * @param string $type
     * @param string $project
     */
    public function __construct($name, $license, $link, $type, $project)
    {
        $this->name = $name;
        $this->license = $license;
        $this->link = $link;
        $this->type = $type;
        $this->project = $project;
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
