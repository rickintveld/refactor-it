<?php
namespace Refactor\Console;

use Cowsayphp\Farm;

/**
 * Class Animal
 * @package Refactor\Console
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
     */
    private function randomAnimal(): string
    {
        $animals = [
            \Cowsayphp\Farm\Cow::class,
            \Cowsayphp\Farm\Tux::class,
            \Cowsayphp\Farm\Whale::class,
        ];

        $randomKey = array_rand($animals, 1);

        return $animals[$randomKey];
    }
}
