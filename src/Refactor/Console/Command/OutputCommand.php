<?php
namespace Refactor\Console\Command;

use Refactor\Console\Output;
use Refactor\Validator\ApplicationValidator;
use Symfony\Component\Console\Output\OutputInterface;

class OutputCommand implements \Refactor\Console\Command\OutputInterface
{
    protected ApplicationValidator $applicationValidator;
    private Output $output;

    public function __construct()
    {
        $this->applicationValidator = new ApplicationValidator();
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = new Output($output);
    }

    /**
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }
}
