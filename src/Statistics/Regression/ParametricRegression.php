<?php

namespace MathPHP\Statistics\Regression;

abstract class ParametricRegression extends Regression
{
    /**
     * An array of model parameters
     */
    protected $parameters;
    /**
     * Have the parent separate the points into xs and ys.
     * Calculate the regression parameters
     *
     * @param float[] $points
     */
    public function __construct(array $points)
    {
        parent::__construct($points);
        $this->calculate();
    }
    public abstract function calculate();
    /**
     * Return the model as a string
     */
    public function __toString()
    {
        return $this->getEquation();
    }
    /**
     * Get the equation
     * Uses the model's getModelEquation method.
     *
     * @return string
     */
    public function getEquation()
    {
        return $this->getModelEquation($this->parameters);
    }
    /**
     * Get the parameters
     * Uses the model's getModelParameters method.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->getModelParameters($this->parameters);
    }
    public abstract function getModelEquation(array $parameters);
    public abstract function getModelParameters(array $parameters);
}