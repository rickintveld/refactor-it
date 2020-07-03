<?php
namespace Refactor\Config;

/**
 * Interface JsonParser
 * @package Rocket\Refactor\Common
 */
interface JsonParserInterface
{
    /**
     * @param string $json
     * @return object
     */
    public function fromJSON(string $json);

    /**
     * @return string
     */
    public function toJSON(): string;
}
