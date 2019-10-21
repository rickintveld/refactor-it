<?php
namespace Refactor\Console\Command;

use Refactor\Console\VersionControl;
use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
use Refactor\Git\Modifications;
use Refactor\Notification\Notifier;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder extends Notifier
{
    public const GIT = 'git';
    public const GIT_CONFIG = '.git';

    /** @var Modifications */
    protected $modifications;

    /** @var VersionControl */
    protected $versionControl;

    /**
     * Finder constructor.
     */
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
        if (empty($this->versionControl->validateVcsUsage())) {
            // @codeCoverageIgnoreStart
            $this->push('Exception Error [1570009542585]', 'There is no version control system found in your project!', true);
            throw new UnknownVcsTypeException('There is no version control system found in your project!', 1570009542585);
            // @codeCoverageIgnoreEnd
        }

        return $this->filterForPhpFiles($this->modifications->getAllModifiedFiles());
    }

    /**
     * @param array $files
     * @return array
     */
    private function filterForPhpFiles(array $files): array
    {
        $phpFiles = [];
        foreach ($files as $file) {
            if (!empty($file) && substr($file, -4) === '.php') {
                $phpFiles[] = preg_replace('/\s+/', '\ ', $file);
            }
        }

        return $phpFiles;
    }
}
