<?php
namespace Refactor\Common;

/**
 * Interface JsonParser
 * @package Rocket\Refactor\Common
 */
interface JsonParserInterface
{
    /**
     * @param array $json
     * @return object
     */
    public function fromJSON(array $json);

    /**
     * @return string
     */
    public function toJSON(): string;
}
