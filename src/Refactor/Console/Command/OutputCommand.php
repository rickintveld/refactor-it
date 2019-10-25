<?php
namespace Refactor\Console\Command;

use Refactor\Console\Output;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 * @package Refactor\Console\Command
 */
class OutputCommand implements \Refactor\Console\Command\OutputInterface
{
    /** @var Output */
    private $output;

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
