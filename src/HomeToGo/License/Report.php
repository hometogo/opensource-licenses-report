<?php

namespace HomeToGo\License;

class Report
{
    /**
     * @var Dependency[]
     */
    private $dependencies = [];

    /**
     * @return array
     */
    public function getHeader()
    {
        return array_merge(
            ['Name', 'Type', 'License', 'Environment', 'Link'],
            $this->getProjectMap()
        );
    }

    /**
     * @return array
     */
    public function getBody()
    {
        $out = [];

        $map = array_fill_keys($this->getProjectMap(), '');

        foreach ($this->dependencies as $dependency) {
            $out[] = array_merge(
                [
                    $dependency->getName(),
                    $dependency->getType(),
                    $dependency->getLicense(),
                    $dependency->getEnv(),
                    $dependency->getLink()
                ],
                array_values(array_merge($map, $dependency->getProjects()))
            );
        }

        return $out;
    }

    /**
     * @param Dependency $dependency
     */
    public function addDependency(Dependency $dependency)
    {
        if (isset($this->dependencies[$dependency->getId()])) {
            $target = $this->dependencies[$dependency->getId()];

            foreach ($dependency->getProjects() as $project => $version) {
                $target->addProject($project, $version);
            }

            $dependency->getEnv() === Dependency::ENV_PROD && $target->setEnv(Dependency::ENV_PROD);
        } else {
            $this->dependencies[$dependency->getId()] = $dependency;
        }
    }

    /**
     * @return array
     */
    protected function getProjectMap()
    {
        $map = [];

        foreach ($this->dependencies as $dependency) {
            $map = array_merge($map, $dependency->getProjects());
        }

        return array_keys($map);
    }
}
