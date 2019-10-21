<?php
namespace Refactor\App;

use Gitonomy\Git\Diff\Diff;
use Gitonomy\Git\WorkingCopy;

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
        $rootPath = dirname(__DIR__, 3);
        $this->repository = new \Gitonomy\Git\Repository($rootPath);
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
