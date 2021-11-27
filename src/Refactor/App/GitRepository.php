<?php
namespace Refactor\App;

use Gitonomy\Git\Diff\Diff;
use Gitonomy\Git\Repository;
use Gitonomy\Git\WorkingCopy;
use Refactor\Utility\PathUtility;
use Symfony\Component\Process\Process;

class GitRepository
{
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new Repository(PathUtility::getRootPath());
    }

    /**
     * @return \Gitonomy\Git\Repository
     */
    protected function getRepository(): Repository
    {
        return $this->repository;
    }

    /**
     * @return \Gitonomy\Git\WorkingCopy
     */
    public function getWorkingCopy(): WorkingCopy
    {
        return $this->getRepository()->getWorkingCopy();
    }

    /**
     * @return \Gitonomy\Git\Diff\Diff
     */
    public function getStagedModifications(): Diff
    {
        return $this->getWorkingCopy()->getDiffStaged();
    }

    /**
     * @return \Gitonomy\Git\Diff\Diff
     */
    public function getPendingModifications(): Diff
    {
        return $this->getWorkingCopy()->getDiffPending();
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        $output = [];
        $process = new Process(['git','config','user.name']);
        $process->start();
        while ($process->isRunning()) {
            $output = $process->getOutput();
        }

        return empty($output) ? 'Unknown' : $output;
    }
}
