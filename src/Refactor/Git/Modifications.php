<?php
namespace Refactor\Git;

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
        $this->repository = new \Refactor\App\Repository();
    }

    /**
     * @return array
     */
    public function getAllModifiedFiles(): array
    {
        $files = [];
        $pending = $this->repository->getPendingModifications();
        $staged = $this->repository->getStagedModifications();

        /** @var \Gitonomy\Git\Diff\File $file */
        foreach ($pending->getFiles() as $file) {
            $files[] = getcwd() . '/' . $file->getName();
        }

        /** @var \Gitonomy\Git\Diff\File $stage */
        foreach ($staged->getFiles() as $stage) {
            $files[] = getcwd() . '/' . $stage->getName();
        }

        return $files;
    }
}
