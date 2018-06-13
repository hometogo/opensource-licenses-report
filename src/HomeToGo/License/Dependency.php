<?php

namespace HomeToGo\License;

class Dependency
{

    const TYPE_PHP = 'php';
    const TYPE_JS = 'js';

    const ENV_DEV = 'dev';
    const ENV_PROD = 'prod';

    /** @var string */
    private $name;

    /** @var string */
    private $license;

    /** @var string */
    private $link;

    /** @var string */
    private $type;

    /** @var array name => version */
    private $projects;

    /** @var string */
    private $env;

    /**
     * @param string $name
     * @param string $license
     * @param string $link
     * @param string $type
     * @param array $projects
     */
    public function __construct($name, $license, $link, $type, array $projects)
    {
        $this->name = $name;
        $this->license = $license;
        $this->link = $link;
        $this->type = $type;
        $this->projects = $projects;
    }

    /**
     * @return array
     */
    public function getProjects()
    {
        return $this->projects;
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
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
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

    /**
     * @param string $project
     * @param string $version
     */
    public function addProject($project, $version)
    {
        $this->projects[$project] = $version;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getName() . $this->getLicense();
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param string $env
     */
    public function setEnv($env)
    {
        $this->env = $env;
    }
}
