<?php

namespace HomeToGo\License;

class Report
{

    const DEFAULT_COLUMNS = ['Name', 'Type', 'License', 'Environment', 'Link'];

    /**
     * @var Dependency[]
     */
    private $dependencies = [];

    /**
     * @var array
     */
    private $columns = self::DEFAULT_COLUMNS;

    /**
     * @var bool
     */
    private $showProjectColumns = true;

    /**
     * @var bool
     */
    private $unique = false;

    /**
     * @param array $columns
     * @return Report
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param bool $showProjectColumns
     * @return Report
     */
    public function setShowProjectColumns($showProjectColumns)
    {
        $this->showProjectColumns = $showProjectColumns;
        return $this;
    }

    /**
     * @param bool $unique
     * @return Report
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return array_merge(
            $this->columns,
            $this->showProjectColumns ? $this->getProjectMap() : []
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
                array_values(
                    array_intersect_key(
                        [
                            'Name' => $dependency->getName(),
                            'Type' => $dependency->getType(),
                            'License' => $dependency->getLicense(),
                            'Environment' => $dependency->getEnv(),
                            'Link' => $dependency->getLink()
                        ],
                        array_fill_keys($this->columns, 1)
                    )
                ),
                $this->showProjectColumns ? array_values(array_merge($map, $dependency->getProjects())) : []
            );
        }

        return $this->unique ? $this->getUniqueLines($out) : $out;
    }

    /**
     * @param array $table
     * @return array
     */
    private function getUniqueLines($table)
    {
        $index = [];

        foreach ($table as $line) {
            $index[join('', $line)] = $line;
        }

        return array_values($index);
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
