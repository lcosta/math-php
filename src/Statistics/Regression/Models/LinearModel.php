<?php

namespace MathPHP\Statistics\Regression\Models;

trait LinearModel
{
    /** @var int b parameter index */
    protected static $B = 0;
    /** @var int m parameter index */
    protected static $M = 1;
    /**
     * Evaluate the model given all the model parameters
     * y = mx + b
     *
     * @param float $x
     * @param array $params
     *
     * @return float y evaluated
     */
    public static function evaluateModel($x, array $params)
    {
        $m = $params[self::$M];
        $b = $params[self::$B];
        return $m * $x + $b;
    }
    /**
     * Get regression parameters (coefficients)
     * m = slope
     * b = y intercept
     *
     * @param array $params
     *
     * @return array [ m => number, b => number ]
     */
    public static function getModelParameters(array $params)
    {
        return ['m' => $params[self::$M], 'b' => $params[self::$B]];
    }
    /**
     * Get regression equation (y = mx + b)
     *
     * @param array $params
     *
     * @return string
     */
    public static function getModelEquation(array $params)
    {
        return sprintf('y = %fx + %f', $params[self::$M], $params[self::$B]);
    }
}