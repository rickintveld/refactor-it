<?php
namespace Refactor\Config;

use Refactor\Common\JsonParser;

/**
 * Class Rules
 * @package Refactor\Config
 */
class Rules implements JsonParser
{
    const RULES_FILE = 'rules.json';

    /**
     * @param array $json
     * @return Rules
     */
    public function fromJSON(array $json)
    {

        return $this;
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        $properties = [];
        $variables = get_object_vars($this);

        foreach ($variables as $key => $value) {
            $snakeCased = preg_replace('/[A-Z]/', '_$0', $key);
            $snakeCased = strtolower($snakeCased);
            $snakeCasedKey = ltrim($snakeCased, '_');
            $properties[$snakeCasedKey] = $value;
        }

        $properties = array_merge($properties, ['@PSR2' => true]);

        return json_encode(array_filter($properties, function ($value) {
            return $value !== null;
        }), JSON_PRETTY_PRINT);
    }
}