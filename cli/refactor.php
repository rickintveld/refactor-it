<?php

use Refactor\Fixer\Fixer;
use Refactor\Init;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

const REFACTOR_IT_VERSION = '1.0.0';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
   die('Something went wrong while loading the autoloader!..');
}

/* Application initiation */
$app = new Application('Refactor it', REFACTOR_IT_VERSION);

$init = new Init();
$fixer = new Fixer();

$app->command('config [--reset-project]', function ($resetProject, InputInterface $input, OutputInterface $output)  use ($init) {

    try {
        $init->execute($input, $output, $this->getHelperSet(), ['reset-project' => $resetProject]);
    } catch (\Exception $exception) {
        $output->writeln('<error>' . $exception->getMessage() . '</error>');
    }

})->descriptions('(re)sets the refactor-it pattern config');

$app->command('diffs', function (InputInterface $input, OutputInterface $output) use ($fixer) {

    try {
        $fixer->execute($input, $output, $this->getHelperSet());
    } catch (\Exception $exception) {
        $output->writeln('<error>' . $exception->getMessage() . '</error>');
    }

})->descriptions('Refactors your PHP project GIT diffs to the selected coding standards!');

/** @noinspection PhpUnhandledExceptionInspection because we do want to display the error through Symfony Console and not handle it ourselves */
$app->run();