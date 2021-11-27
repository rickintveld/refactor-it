<?php
namespace Refactor\Troll;

use Foaas\Foaas;

class Fuck
{
    private Foaas $fuck;

    public function __construct()
    {
        $this->fuck = new Foaas();
    }

    /**
     * @param string $name
     * @param string|null $from
     * @return string
     */
    public function shoutTo(string $name, string $from = null): string
    {
        return $from
                ? $this->fuck->shout()->{$this->getRandomFuckToFrom()}($name, $from)
                : $this->fuck->shout()->{$this->getRandomFuck()}($name);
    }

    /**
     * @param string $name
     * @param string|null $from
     * @return string
     */
    public function speakTo(string $name, string $from = null): string
    {
        return $from !== null
                ? $this->fuck->{$this->getRandomFuckToFrom()}($name, $from)
                : $this->fuck->{$this->getRandomFuck()}($name);
    }

    /**
     * @param string $from
     * @return string
     */
    public function speakFrom(string $from): string
    {
        return $this->fuck->{$this->getRandomFuckFrom()}($from);
    }

    /**
     * @return string
     */
    private function getRandomFuck(): string
    {
        $trolls = ['everything', 'everyone', 'pink', 'life', 'awesome', 'tucker', 'bucket', 'diabetes', 'fascinating', 'horse'];

        return $this->getTroll($trolls);
    }

    /**
     * @return string
     */
    private function getRandomFuckToFrom(): string
    {
        $trolls = ['you', 'off', 'ing', 'shakespeare', 'linus', 'king', 'cocksplat', 'dalton', 'equity', 'look', 'nugget', 'outside'];

        return $this->getTroll($trolls);
    }

    /**
     * @return string
     */
    private function getRandomFuckFrom(): string
    {
        $trolls = ['zero', 'what', 'tucker', 'too', 'this', 'that', 'thanks', 'single', 'shit', 'sake', 'rtfm', 'ridiculous', 'retard', 'programmer', 'ratsarse', 'no', 'maybe', 'logs', 'fyyff', 'ftfy', 'cup'];

        return $this->getTroll($trolls);
    }

    /**
     * @param array $trolls
     * @return string
     */
    private function getTroll(array $trolls): string
    {
        return $trolls[array_rand($trolls, 1)];
    }
}
