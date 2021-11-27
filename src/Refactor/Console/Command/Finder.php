<?php
namespace Refactor\Console\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Refactor\Console\VersionControl;
use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
use Refactor\Git\Modifications;

class Finder
{
    public const GIT = 'git';
    public const GIT_CONFIG = '.git';

    protected Modifications $modifications;
    protected VersionControl $versionControl;

    public function __construct()
    {
        $this->modifications = new Modifications();
        $this->versionControl = new VersionControl();
    }

    /**
     * @throws UnknownVcsTypeException
     * @throws WrongVcsTypeException
     * @return array
     */
    public function getChangedFiles(): array
    {
        if (empty($this->versionControl->isGitProject())) {
            // @codeCoverageIgnoreStart
            throw new UnknownVcsTypeException('There is no version control system found in your project!', 1570009542585);
            // @codeCoverageIgnoreEnd
        }

        return $this->findPhpFiles($this->modifications->getAllModifiedFiles());
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection<string> $collection
     * @return array
     */
    private function findPhpFiles(ArrayCollection $collection): array
    {
        $files = [];
        foreach ($collection as $file) {
            if (!empty($file) && substr($file, -4) === '.php') {
                $files[] = preg_replace('/\s+/', '\ ', $file);
            }
        }

        return $files;
    }
}
