<?php
namespace Refactor\Console\Command;

/**
 * Interface OutputInterface
 * @package Refactor\Console\Command
 */
interface OutputInterface
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function setOutput(\Symfony\Component\Console\Output\OutputInterface $output): void;

    /**
     * @return \Refactor\Console\Output
     */
    public function getOutput(): \Refactor\Console\Output;
}
