<?php

namespace Cacofony\Entity;

class Dependency
{
    private string $name;
    private string $type;
    private bool $fromURL;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Dependency
     */
    public function setName(string $name): Dependency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Dependency
     */
    public function setType(string $type): Dependency
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFromURL(): bool
    {
        return $this->comesFromURL;
    }

    /**
     * @param bool $comesFromURL
     * @return Dependency
     */
    public function setFromURL(bool $comesFromURL): Dependency
    {
        $this->comesFromURL = $comesFromURL;
        return $this;
    }
}