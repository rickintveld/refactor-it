<?php
namespace Refactor\Console\Command;

use Refactor\Console\Output;

interface OutputInterface
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function setOutput(\Symfony\Component\Console\Output\OutputInterface $output): void;

    /**
     * @return \Refactor\Console\Output
     */
    public function getOutput(): Output;
}
