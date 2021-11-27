<?php
namespace Refactor\tests\Utility;

use PHPUnit\Framework\TestCase;
use Refactor\Utility\PathUtility;

class PathUtilityTest extends TestCase
{
    public function testRefactorItPathExist(): void
    {
        $path = PathUtility::getRefactorItPath();
        self::assertDirectoryExists($path);
    }

    public function testRefactorItRuleFileExist(): void
    {
        $file = PathUtility::getRefactorItRulesFile();
        self::assertFileExists($file);
    }

    public function testRefactorItGitIgnoreFileExist(): void
    {
        $file = PathUtility::getGitIgnoreFile();
        self::assertFileExists($file);
    }

    public function testPrivateFolderExist(): void
    {
        $file = PathUtility::getPrivatePath();
        self::assertFileExists($file);
    }
}
