<?php
namespace Refactor\Git;

use Doctrine\Common\Collections\ArrayCollection;
use Refactor\App\GitRepository;
use Refactor\Utility\PathUtility;

class Modifications
{
    private GitRepository $repository;

    public function __construct()
    {
        $this->repository = new GitRepository();
    }

    /**
     * @return ArrayCollection<string>
     */
    public function getAllModifiedFiles(): ArrayCollection
    {
        $files = new ArrayCollection();

        $modifiedFiles = [
            ...$this->repository->getPendingModifications()->getFiles(),
            ...$this->repository->getStagedModifications()->getFiles()
        ];

        array_map(static function ($file) use ($files) {
            /** @var \Gitonomy\Git\Diff\File $file */
            if (false === $file->isDelete()) {
                $files->add(PathUtility::getRootPath() . '/' . $file->getName());
            }
        }, $modifiedFiles);

        return $files;
    }
}
