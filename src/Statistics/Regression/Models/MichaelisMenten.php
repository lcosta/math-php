<?php

namespace MathPHP\Statistics\Regression\Models;

/**
 * The Michaelis-Menten equation is used to model enzyme kinetics.
 *       V * x
 * y = ----------
 *       K + x
 *
 *
 * https://en.wikipedia.org/wiki/Michaelis%E2%80%93Menten_kinetics
 */
trait MichaelisMenten
{
    /** @var int V parameter index */
    protected static $V = 0;
    /** @var int K parameter index */
    protected static $K = 1;
    /**
     * Evaluate the equation using the regression parameters
     * y = (V * X) / (K + X)
     *
     * @param float $x
     * @param array $params
     *
     * @return float y evaluated
     */
    public static function evaluateModel($x, array $params)
    {
        $V = $params[self::$V];
        $K = $params[self::$K];
        return $V * $x / ($K + $x);
    }
    /**
     * Get regression parameters (V and K)
     *
     * @param array $params
     *
     * @return array [ V => number, K => number ]
     */
    public static function getModelParameters(array $params)
    {
        return ['V' => $params[self::$V], 'K' => $params[self::$K]];
    }
    /**
     * Get regression equation (y = V * X / (K + X))
     *
     * @param array $params
     *
     * @return string
     */
    public static function getModelEquation(array $params)
    {
        return sprintf('y = %fx/(%f+x)', $params[self::$V], $params[self::$K]);
    }
}