<?php
namespace Rocket\RefactorIt\Config;

use Rocket\RefactorIt\Common\JsonParser;

/**
 * Class RefactorItConfig
 * @package Rocket\RefactorIt\Config
 */
class Config implements JsonParser
{
    const CONFIG_FILE = 'config.json';

    /** @var array */
    protected $excludedPaths = [];

    /** @var string */
    protected $format = 'php';

    /** @var string */
    protected $indenting = "\t";

    /** @var string */
    protected $lineEnding = "\r\n";

    /** @var string */
    protected $projectPath = '';

    /**
     * @return array
     */
    public function getExcludedPaths(): array
    {
        return $this->excludedPaths;
    }

    /**
     * @param array $excludedPaths
     * @return $this
     */
    public function setExcludedPaths(array $excludedPaths): Config
    {
        $this->excludedPaths = $excludedPaths;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format): Config
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getIndenting(): string
    {
        return $this->indenting;
    }

    /**
     * @param string $indenting
     * @return $this
     */
    public function setIndenting(string $indenting): Config
    {
        $this->indenting = $indenting;

        return $this;
    }

    /**
     * @return string
     */
    public function getLineEnding(): string
    {
        return $this->lineEnding;
    }

    /**
     * @param string $lineEnding
     * @return $this
     */
    public function setLineEnding(string $lineEnding): Config
    {
        $this->lineEnding = $lineEnding;

        return $this;
    }

    /**
     * @return string
     */
    public function getProjectPath(): string
    {
        return $this->projectPath;
    }

    /**
     * @param string $projectPath
     * @return $this
     */
    public function setProjectPath(string $projectPath): Config
    {
        $this->projectPath = $projectPath;

        return $this;
    }

    /**
     * @param array $json
     * @return Config
     */
    public function fromJSON(array $json): Config
    {
        if (isset($json['excludedPaths']) && is_array($json['excludedPaths']) && count($json['excludedPaths']) > 0) {
            $this->setExcludedPaths($json['excludedPaths']);
        }

        if (isset($json['format']) && strlen($json['format']) > 0) {
            $this->setFormat($json['format']);
        }

        if (isset($json['indenting']) && strlen($json['indenting']) > 0) {
            $this->setIndenting($json['indenting']);
        }

        if (isset($json['lineEnding']) && strlen($json['lineEnding']) > 0) {
            $this->setLineEnding($json['lineEnding']);
        }

        if (isset($json['projectPath']) && strlen($json['projectPath']) > 0) {
            $this->setProjectPath($json['projectPath']);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        $variables = get_object_vars($this);

        return json_encode(array_filter($variables, function ($value) {
            return $value !== null;
        }), JSON_PRETTY_PRINT);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function checkRequiredConfig(): bool
    {
        if (empty($this->excludedPaths) === true) {
            Throw new \Exception('No excluded paths are set in the config');
        }

        if (empty($this->format) === true) {
            Throw new \Exception('No format is set in the config');
        }

        if (empty($this->indenting) === true) {
            Throw new \Exception('No indenting is set in the config');
        }

        if (empty($this->lineEnding) === true) {
            Throw new \Exception('No line ending is set in the config');
        }

        if (empty($this->projectPath) === true) {
            Throw new \Exception('No project path is set in the config');
        }

        return true;
    }
}