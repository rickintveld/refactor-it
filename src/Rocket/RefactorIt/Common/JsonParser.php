<?php
namespace Rocket\RefactorIt\Common;

/**
 * Interface JsonParser
 * @package Rocket\Refactor\Common
 */
interface JsonParser
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
