<?php
namespace Refactor\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Composer
{
    private string $packageName;
    private string $homepage;
    private string $description;
    private string $license;
    private string $version;
    private ArrayCollection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return \Refactor\Model\Composer
     */
    public function setPackageName(string $packageName): self
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage
     * @return \Refactor\Model\Composer
     */
    public function setHomepage(string $homepage): self
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return \Refactor\Model\Composer
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @param string $license
     * @return \Refactor\Model\Composer
     */
    public function setLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return \Refactor\Model\Composer
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection<Author>
     */
    public function getAuthors(): ArrayCollection
    {
        return $this->authors;
    }

    /**
     * @param \Refactor\Model\Author $author
     * @return \Refactor\Model\Composer
     */
    public function addAuthor(Author $author): self
    {
        if (!$this->getAuthors()->contains($author)) {
            $this->getAuthors()->add($author);
        }

        return $this;
    }
}
