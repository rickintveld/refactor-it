<?php
namespace Refactor\Config;

/**
 * Class Rules
 * @package Refactor\Config
 */
class Rules
{
    const RULES_FILE = 'rules.json';

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
