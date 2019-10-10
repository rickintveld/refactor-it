<?php
namespace Refactor\Utility;

use PHPUnit\Framework\TestCase;

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
}
