<?php

use Refactor\App\Composer;
use Refactor\Console\Command\Fixer;
use Refactor\Console\Command\History;
use Refactor\Console\Command\Init;
use Refactor\Console\Command\Project;
use Refactor\Console\Command\Remover;
use Refactor\Log\HistoryLogger;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

if (file_exists(getcwd() . '/vendor/autoload.php')) {
    require(getcwd() . '/vendor/autoload.php');
} else {
    throw new \RuntimeException('Unable to load autoloader.');
}

$composer = new Composer();
$application = new Application('Refactor it', $composer->getVersion());

$history = new History();
$historyLogger = new HistoryLogger();
$init = new Init();
$fixer = new Fixer();
$project = new Project();
$remover = new Remover();

$application->command('init [--reset-rules]', function ($resetRules, InputInterface $input, OutputInterface $output) use ($init, $historyLogger) {
    $resetRules ? $historyLogger->log("refactor-it init --reset-rules\n") : $historyLogger->log("refactor-it init\n");
    $init->execute($input, $output, $this->getHelperSet(), ['reset-rules' => $resetRules]);
})->descriptions('Generates the file with the refactoring rules', ['--reset-rules' => 'Resets the rules to the default']);

$application->command('fix', function (InputInterface $input, OutputInterface $output) use ($fixer, $historyLogger) {
    $historyLogger->log("refactor-it fix\n");

    try {
        $fixer->execute($input, $output, $this->getHelperSet());
    } catch (\Exception $exception) {
        $output->writeln('<error>' . $exception->getMessage() . '</error>');
    }
})->descriptions('Refactors your PHP project GIT diffs to the selected coding standards');

$application->command('remove', function (InputInterface $input, OutputInterface $output) use ($remover, $historyLogger) {
    $historyLogger->log("refactor-it remove\n");
    $remover->execute($input, $output, $this->getHelperSet());
})->descriptions('Removes the Refactor-it folder and config files');

$application->command('fix-all', function (InputInterface $input, OutputInterface $output) use ($project, $historyLogger) {
    $historyLogger->log("refactor-it fix-all\n");
    $project->execute($input, $output, $this->getHelperSet());
})->descriptions('Select the project source folder and refactor all the PHP files to the selected coding standards');

$application->command('history [--clear]', function ($clear, InputInterface $input, OutputInterface $output) use ($history) {
    $history->execute($input, $output, $this->getHelperSet(), ['clear' => $clear]);
})->descriptions('Displays a list of the command history', ['--clear' => 'Removes your refactor-it command history']);

$application->setAutoExit(true);

/** @noinspection PhpUnhandledExceptionInspection because we do want to display the error through Symfony Console and not handle it ourselves */
$application->run();
