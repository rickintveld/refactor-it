<?php
namespace Refactor\App;

/**
 * Class Composer
 * @package Refactor\App
 */
class Composer
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        $composer = file_get_contents(dirname(__DIR__, 3) . '/composer.json');
        $data = json_decode($composer, true);

        return (string)$data['version'];
    }
}