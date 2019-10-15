<?php
namespace Refactor\tests\Utility;

use PHPUnit\Framework\TestCase;
use Refactor\Utility\PathUtility;

/**
 * Class PathUtilityTest
 * @package Refactor\Utility
 */
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

    public function testRefactorItGitIgnoreFileExist()
    {
        $file = PathUtility::getGitIgnoreFile();
        self::assertFileExists($file);
    }

    public function testPrivateFolderExist()
    {
        $file = PathUtility::getPrivatePath();
        self::assertFileExists($file);
    }
}
