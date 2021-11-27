<?php
namespace Refactor\App;

use Doctrine\Common\Collections\ArrayCollection;
use Refactor\Builder\ComposerBuilder;

class Composer
{
    private \Refactor\Model\Composer $composer;

    public function __construct()
    {
        $this->composer = (new ComposerBuilder())->build();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->composer->getVersion();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAuthors(): ArrayCollection
    {
        return $this->composer->getAuthors();
    }

    public function getPackageName(): string
    {
        return $this->composer->getPackageName();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->composer->getDescription();
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->composer->getLicense();
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->composer->getHomepage();
    }
}
