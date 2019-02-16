<?php

use Rocket\RefactorIt\Init;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

const REFACTOR_IT_VERSION = '1.0.0';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
   die('Something went wrong while loading the autoloader!..');
}

/* Application initiation */
$app = new Application('Refactor it', REFACTOR_IT_VERSION);

$init = new Init();

$app->command('config [--reset-project]', function ($resetProject, InputInterface $input, OutputInterface $output)  use ($init) {

    /**
     * @todo Create the rules json
     */

    $init->execute($input, $output, $this->getHelperSet(), ['reset-project' => $resetProject]);

})->descriptions('(re)sets the refactor-it pattern config');

$app->command('it [--all]', function ($all, InputInterface $input, OutputInterface $output) {
    /**
     * @todo
     * Get the GIT diff names and store them into a array
     * Get the refactor-it config.json content
     * Loop true the files and refactor the code
     */

    if ($all) {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelperSet()->get('question');

        $output->writeln('<info>The files in the gitignore will be skipped!</info>');
        $question = new ConfirmationQuestion('Are you sure you want to refactor the whole project [Y|n] ?', false);

        if ($helper->ask($input, $output, $question)) {
            $output->writeln('Refactoring the whole project');
        }
    }

})->descriptions('Refactors your PHP project to the selected coding standards!');

/** @noinspection PhpUnhandledExceptionInspection because we do want to display the error through Symfony Console and not handle it ourselves */
$app->run();