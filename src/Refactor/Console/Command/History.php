<?php
namespace Refactor\Console\Command;

use Refactor\Cache\GarbageCollector;
use Refactor\Console\Output;
use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class History
 * @package Refactor\Console\Command
 */
class History extends OutputCommand implements CommandInterface
{
    /** @var \Refactor\Cache\GarbageCollector */
    private $garbageCollector;

    public function __construct()
    {
        parent::__construct();

        $this->garbageCollector = new GarbageCollector();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @param array ...$parameters
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        if (!$this->applicationValidator->validate()) {
            $this->getOutput()->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();

            return;
        }

        if (isset($parameters['clear']) && true === $parameters['clear']) {
            $this->clearHistory();

            return;
        }

        $this->askHistoryRowQuestion($input, $output, $helperSet);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @throws \Exception
     */
    private function askHistoryRowQuestion(InputInterface $input, OutputInterface $output, HelperSet $helperSet): void
    {
        /** @var QuestionHelper $helper */
        $helper = $helperSet->get('question');
        $question = new ChoiceQuestion(
            'Please select the number of history rows',
            range(10, 100, 10)
        );

        $question->setErrorMessage('Selected value %s is invalid!');
        $question->setMaxAttempts(3);

        if ($answer = $helper->ask($input, $output, $question)) {
            $this->showHistory($answer);
        }
    }

    /**
     * @param int $rows
     * @throws \Exception
     */
    private function showHistory(int $rows): void
    {
        if (!file_exists(PathUtility::getHistoryFile())) {
            $this->noHistoryFound();

            return;
        }

        $history = explode("\n", file_get_contents(PathUtility::getHistoryFile()));

        if (empty($history)) {
            $this->noHistoryFound();

            return;
        }

        foreach (array_slice(array_reverse($history), 0, $rows) as $row) {
            $this->getOutput()->addLine($row, Output::FORMAT_COMMENT);
        }

        $this->getOutput()->writeLines();
    }

    /**
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    private function noHistoryFound(): void
    {
        $this->getOutput()
            ->addLine('No refactor-it history found!', Output::FORMAT_ERROR)
            ->addFuckingLine(Output::TROLL_TO)
            ->writeLines();
    }

    /**
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    private function clearHistory(): void
    {
        $this->garbageCollector->removeHistory();
        $this->getOutput()
            ->addLine('The refactor-it command history is removed', Output::FORMAT_COMMENT)
            ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();
    }
}
