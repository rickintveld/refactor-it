<?php
namespace Refactor\Validator;

/**
 * Class Validator
 * @package Refactor\Validator
 */
interface ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate(): bool;
}
