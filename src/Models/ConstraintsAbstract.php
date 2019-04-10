<?php


namespace HoloConstraints\Models;


use Holo\Constraints\ConstraintsContract;
use HoloConstraints\Exceptions\ConstraintNotFulfilledException;

trait ConstraintsAbstract
{
    public $constraints = [];

    /**
     * ConstraintsAbstract constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->registerConstraints();
    }

    /**
     * Register constraints to be evaluated.
     */
    public function registerConstraints(): void
    {
        $methods = get_class_methods(get_class($this));
        $filtered = array_values(array_filter($methods, function ($value) {
            return preg_match('/Constraint$/', $value);
        }));
        foreach ($filtered as $constraint) {
            $this->addConstraintFunction($constraint);
        }
    }

    /**
     * Add constraints validator based on method name..
     * All constraints should return boolean.
     *
     * @param string $methodName
     *
     * @return array
     */
    public function addConstraintFunction(string $methodName): array
    {
        array_push($this->constraints, $methodName);
        return $this->constraints;
    }

    /**
     * Checks if all constraints passes.
     *
     * @return bool
     * @throws ConstraintNotFulfilledException
     */
    public function validateConstraints(): bool
    {
        foreach ($this->constraints as $constraint) {
            if ($result = !$this->$constraint) {
                throw new ConstraintNotFulfilledException(
                    $constraint . 'did NOT complete validation.'
                );
            }
        }
        return true;
    }
}
