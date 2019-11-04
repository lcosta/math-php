<?php

namespace MathPHP\Statistics\Regression;

/**
 * Base class for regressions.
 */
abstract class Regression
{
    /**
     * Array of x and y points: [ [x, y], [x, y], ... ]
     * @var array
     */
    protected $points;
    /**
     * X values of the original points
     * @var array
     */
    protected $xs;
    /**
     * Y values of the original points
     * @var array
     */
    protected $ys;
    /**
     * Number of points
     * @var int
     */
    protected $n;
    /**
     * Constructor - Prepares the data arrays for regression analysis
     *
     * @param array $points [ [x, y], [x, y], ... ]
     */
    public function __construct(array $points)
    {
        $this->points = $points;
        $this->n = count($points);
        // Get list of x points and y points.
        // This will be fine for linear or polynomial regression, where there is only one x,
        // but if expanding to multiple linear, the format will have to change.
        $this->xs = array_map(function ($point) {
            return $point[0];
        }, $points);
        $this->ys = array_map(function ($point) {
            return $point[1];
        }, $points);
    }
    /**
     * Evaluate the regression equation at x
     *
     * @param float $x
     *
     * @return float
     */
    public abstract function evaluate($x);
    /**
     * Get points
     *
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }
    /**
     * Get Xs (x values of each point)
     *
     * @return array of x values
     */
    public function getXs()
    {
        return $this->xs;
    }
    /**
     * Get Ys (y values of each point)
     *
     * @return array of y values
     */
    public function getYs()
    {
        return $this->ys;
    }
    /**
     * Get sample size (number of points)
     *
     * @return int
     */
    public function getSampleSize()
    {
        return $this->n;
    }
    /**
     * Ŷ (yhat)
     * A list of the predicted values of Y given the regression.
     *
     * @return array
     */
    public function yHat()
    {
        return array_map([$this, 'evaluate'], $this->xs);
    }
}