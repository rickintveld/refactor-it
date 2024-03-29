<?php
namespace Refactor\Console;

use Cowsayphp\Farm;
use Cowsayphp\Farm\Cow;
use Cowsayphp\Farm\Tux;
use Cowsayphp\Farm\Whale;

/**
 * @codeCoverageIgnore
 */
class Animal
{
    /**
     * @param string $text
     * @return string
     */
    public function speak(string $text): string
    {
        $animal = Farm::create($this->randomAnimal());

        return $animal->say($text);
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    private function randomAnimal(): string
    {
        $animals = [Cow::class, Tux::class, Whale::class];
        $randomKey = array_rand($animals, 1);

        return $animals[$randomKey];
    }
}
