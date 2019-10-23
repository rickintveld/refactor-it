<?php

use Refactor\App\Composer;
use Refactor\Console\Command\CommitHook;
use Refactor\Console\Command\Fixer;
use Refactor\Console\Command\Project;
use Refactor\Console\Command\Remover;
use Refactor\Init;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

if (file_exists(getcwd() . '/vendor/autoload.php')) {
    require(getcwd() . '/vendor/autoload.php');
} else {
    throw new \RuntimeException('Unable to load autoloader.');
}

$composer = new Composer();
$app = new Application('Refactor it', $composer->getVersion());

$commitHook = new CommitHook();
$init = new Init();
$fixer = new Fixer();
$project = new Project();
$remover = new Remover();

$app->command('init [--reset-rules]', function ($resetRules, InputInterface $input, OutputInterface $output) use ($init) {
    $init->execute($input, $output, $this->getHelperSet(), ['reset-rules' => $resetRules]);
})->descriptions('Generates the file with the refactoring rules', ['--reset-rules' => 'Resets the rules to the default']);

$app->command('diff', function (InputInterface $input, OutputInterface $output) use ($fixer) {
    try {
        $fixer->execute($input, $output, $this->getHelperSet());
    } catch (\Exception $exception) {
        $output->writeln('<error>' . $exception->getMessage() . '</error>');
    }
})->descriptions('Refactors your PHP project GIT diffs to the selected coding standards');

$app->command('remove', function (InputInterface $input, OutputInterface $output) use ($remover) {
    $remover->execute($input, $output, $this->getHelperSet());
})->descriptions('Removes the Refactor-it folder and config files');

$app->command('all', function (InputInterface $input, OutputInterface $output) use ($project) {
    $project->execute($input, $output, $this->getHelperSet());
})->descriptions('Select the project source folder and refactor all the PHP files to the selected coding standards');

$app->command('pre-commit [--remove-hook]', function ($removeHook, InputInterface $input, OutputInterface $output) use ($commitHook) {
    $commitHook->execute($input, $output, $this->getHelperSet(), ['remove-hook' => $removeHook]);
})->descriptions('Adds the GIT pre-commit hook', ['--remove-hook' => 'Removes the pre commit hook']);

/** @noinspection PhpUnhandledExceptionInspection because we do want to display the error through Symfony Console and not handle it ourselves */
$app->run();
