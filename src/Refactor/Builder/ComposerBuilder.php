<?php
namespace Refactor\Builder;

use Refactor\Component\Serializer\JsonSerializer;
use Refactor\Model\Author;
use Refactor\Model\Composer;

class ComposerBuilder
{
    private JsonSerializer $serializer;

    public function __construct()
    {
        $this->serializer = new JsonSerializer();
    }

    /**
     * @return \Refactor\Model\Composer
     */
    public function build(): Composer
    {
        $composerContents = $this->serializer->decode(file_get_contents(dirname(__DIR__, 3) . '/composer.json'));
        $composer = new Composer();
        $composer
            ->setPackageName($composerContents['name'])
            ->setDescription($composerContents['description'])
            ->setLicense($composerContents['license'])
            ->setVersion($composerContents['version'])
            ->setHomepage($composerContents['homepage']);

        array_map(static function ($author) use ($composer) {
            $composer->addAuthor(new Author($author['name'], $author['email']));
        }, $composerContents['authors']);

        return $composer;
    }
}
