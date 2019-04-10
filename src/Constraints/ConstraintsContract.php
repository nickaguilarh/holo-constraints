<?php


namespace HoloConstraints\Constraints;


interface ConstraintsContract
{
    /**
     * Checks if all constraints passes.
     * @return bool
     */
    public function validateConstraints(): bool;

    /**
     * Add constraints validator based on method name..
     * All constraints should return boolean.
     *
     * @param string $methodName
     *
     * @return array
     */
    public function addConstraintFunction(string $methodName): array;

    /**
     * Register constraints to be evaluated.
     */
    public function registerConstraints(): void;
}
