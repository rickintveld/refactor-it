<?php
namespace Refactor\Console;

use Refactor\App\GitRepository;
use Refactor\Exception\InvalidInputException;
use Refactor\Troll\Fuck;
use Symfony\Component\Console\Output\OutputInterface;

class Output
{
    public const FORMAT_COMMENT = 'comment';
    public const FORMAT_ERROR = 'error';
    public const FORMAT_INFO = 'info';
    public const FORMAT_QUESTION = 'question';

    public const TROLL_FROM = 1;
    public const TROLL_FROM_TO = 2;
    public const TROLL_TO = 3;

    private Fuck $fuck;
    private array $lines = [];
    private OutputInterface $output;
    private GitRepository $repository;

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->fuck = new Fuck();
        $this->output = $output;
        $this->repository = new GitRepository();
    }

    /**
     * @param string $text
     * @param string $format
     * @throws \Exception
     * @return Output
     */
    public function addLine(string $text, string $format): Output
    {
        $this->validateFormat($format);
        $this->setLine(sprintf('<%1$s>%2$s</%1$s>', $format, $text));

        return $this;
    }

    /**
     * @param int $trollType
     * @param bool $shout
     * @throws InvalidInputException
     * @return Output
     */
    public function addFuckingLine(int $trollType, bool $shout = false): Output
    {
        $this->validateTrollType($trollType);

        switch ($trollType) {
            case self::TROLL_FROM_TO:
                if ($shout === true) {
                    $outputLine = $this->fuck->shoutTo($this->repository->getUserName(), Signature::team());
                } else {
                    $outputLine = $this->fuck->speakTo($this->repository->getUserName(), Signature::team());
                }
                break;

            case self::TROLL_TO:
                if ($shout === true) {
                    $outputLine = $this->fuck->shoutTo($this->repository->getUserName());
                } else {
                    $outputLine = $this->fuck->speakTo($this->repository->getUserName());
                }
                break;

            default:
                $outputLine = $this->fuck->speakFrom(Signature::team());
                break;
        }

        $this->setLine(sprintf('<%1$s>%2$s</%1$s>', self::FORMAT_QUESTION, $outputLine));

        return $this;
    }

    /**
     * @param string $text
     */
    private function setLine(string $text): void
    {
        $this->lines[] = $text;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    public function writeLines(): void
    {
        foreach ($this->getLines() as $line) {
            $this->output->writeln($line);
        }

        $this->cleanUp();
    }

    /**
     * @param string $format
     * @throws InvalidInputException
     */
    private function validateFormat(string $format): void
    {
        if (!in_array($format, [self::FORMAT_COMMENT, self::FORMAT_ERROR, self::FORMAT_INFO, self::FORMAT_QUESTION], true)) {
            throw new InvalidInputException('Invalid chosen format', 1571944172106);
        }
    }

    /**
     * @param int $trollType
     * @throws InvalidInputException
     */
    private function validateTrollType(int $trollType): void
    {
        if (!in_array($trollType, [self::TROLL_FROM, self::TROLL_FROM_TO, self::TROLL_TO], true)) {
            throw new InvalidInputException('Invalid chosen troll type', 1571944172106);
        }
    }

    private function cleanUp(): void
    {
        unset($this->lines);
    }
}
