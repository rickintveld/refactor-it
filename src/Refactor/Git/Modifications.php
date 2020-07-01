<?php
namespace Refactor\Git;

use Refactor\App\Repository;
use Refactor\Utility\PathUtility;

/**
 * Class Modifications
 * @package Refactor\Git
 */
class Modifications
{
    /** @var \Refactor\App\Repository */
    private $repository;

    /**
     * Modifications constructor.
     */
    public function __construct()
    {
        $this->repository = new Repository();
    }

    /**
     * @return array
     */
    public function getAllModifiedFiles(): array
    {
        $modifiedFiles = array_merge(
            $this->repository->getPendingModifications()->getFiles(),
            $this->repository->getStagedModifications()->getFiles()
        );

        $files = array_map(static function ($file) {
            /** @var \Gitonomy\Git\Diff\File $file */
            return PathUtility::getRootPath() . '/' . $file->getName();
        }, $modifiedFiles);

        return $files;
    }
}
