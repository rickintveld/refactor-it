<?php

use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

const REFACTOR_IT_VERSION = '1.0.3';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    die('Something went wrong while loading the autoloader!..');
}

/* Application initiation */
$app = new Application('Refactor it', REFACTOR_IT_VERSION);

$init = new \Refactor\Init();
$fixer = new \Refactor\Console\Fixer();

$app->command('init [--reset-rules]', function ($resetRules, InputInterface $input, OutputInterface $output) use ($init) {
    $init->execute($input, $output, $this->getHelperSet(), ['reset-rules' => $resetRules]);
})->descriptions('Generates the file with the refactoring rules');

$app->command('diff', function (InputInterface $input, OutputInterface $output) use ($fixer) {
    try {
        $fixer->execute($input, $output, $this->getHelperSet(), null);
    } catch (\Exception $exception) {
        $output->writeln('<error>' . $exception->getMessage() . '</error>');
    }
})->descriptions('Refactors your PHP project GIT diffs to the selected coding standards!');

/** @noinspection PhpUnhandledExceptionInspection because we do want to display the error through Symfony Console and not handle it ourselves */
$app->run();