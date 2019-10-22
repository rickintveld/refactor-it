<?php
namespace Refactor\App;

use Gitonomy\Git\Diff\Diff;
use Gitonomy\Git\WorkingCopy;
use Refactor\Utility\PathUtility;

/**
 * Class Repository
 * @package Refactor\App
 */
class Repository
{
    /** @var \Gitonomy\Git\Repository */
    private $repository;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->repository = new \Gitonomy\Git\Repository(PathUtility::getRootPath());
    }

    /**
     * @return \Gitonomy\Git\Repository
     */
    protected function getRepository(): \Gitonomy\Git\Repository
    {
        return $this->repository;
    }

    /**
     * @return WorkingCopy
     */
    public function getWorkingCopy(): WorkingCopy
    {
        return $this->getRepository()->getWorkingCopy();
    }

    /**
     * @return Diff
     */
    public function getStagedModifications(): Diff
    {
        return $this->getWorkingCopy()->getDiffStaged();
    }

    /**
     * @return Diff
     */
    public function getPendingModifications(): Diff
    {
        return $this->getWorkingCopy()->getDiffPending();
    }
}
