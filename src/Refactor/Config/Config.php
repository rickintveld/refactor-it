<?php
namespace Refactor\Config;

use Refactor\Common\JsonParserInterface;

/**
 * Class RefactorItConfig
 * @package Refactor\Config
 */
class Config implements JsonParserInterface
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

    /** @var string */
    protected $vcs = 'git';

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
     * @return string
     */
    public function getVcs(): string
    {
        return $this->vcs;
    }

    /**
     * @param string $vcs
     */
    public function setVcs(string $vcs)
    {
        $this->vcs = $vcs;
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

        if (isset($json['format']) && empty($json['format']) === false) {
            $this->setFormat($json['format']);
        }

        if (isset($json['indenting']) && empty($json['indenting']) === false) {
            $this->setIndenting($json['indenting']);
        }

        if (isset($json['lineEnding']) && empty($json['lineEnding']) === false) {
            $this->setLineEnding($json['lineEnding']);
        }

        if (isset($json['projectPath']) && empty($json['projectPath']) === false) {
            $this->setProjectPath($json['projectPath']);
        }

        if (isset($json['vcs']) && empty($json['vcs']) === false) {
            $this->setVcs($json['vcs']);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        $properties = get_object_vars($this);

        return json_encode(array_filter($properties, function ($value) {
            return $value !== null;
        }), JSON_PRETTY_PRINT);
    }

    /**
     * @throws \Refactor\Exception\MissingConfigException
     * @return bool
     */
    public function checkRequiredConfig(): bool
    {
        if (empty($this->excludedPaths) === true) {
            throw new \Refactor\Exception\MissingConfigException('No excluded paths are set in the config', 1560518036394);
        }

        if (empty($this->format) === true) {
            throw new \Refactor\Exception\MissingConfigException('No format is set in the config', 1560518031780);
        }

        if (empty($this->indenting) === true) {
            throw new \Refactor\Exception\MissingConfigException('No indenting is set in the config', 1560518028348);
        }

        if (empty($this->lineEnding) === true) {
            throw new \Refactor\Exception\MissingConfigException('No line ending is set in the config', 1560518025278);
        }

        if (empty($this->projectPath) === true) {
            throw new \Refactor\Exception\MissingConfigException('No project path is set in the config', 1560518022664);
        }

        if (empty($this->vcs) === true) {
            throw new \Refactor\Exception\MissingConfigException('No version control system [vsc] is set in the config', 1560518018743);
        }

        return true;
    }
}
