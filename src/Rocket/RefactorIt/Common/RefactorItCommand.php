<?php
namespace Rocket\RefactorIt\Common;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface RefactorCommand
 * @package Rocket\RefactorIt\Common
 */
interface RefactorItCommand
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters);
}