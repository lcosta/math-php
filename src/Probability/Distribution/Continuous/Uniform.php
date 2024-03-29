<?php

namespace MathPHP\Probability\Distribution\Continuous;

use MathPHP\Exception\OutOfBoundsException;
class Uniform extends Continuous
{
    /**
     * Distribution parameter bounds limits
     * a ∈ (-∞,∞)
     * b ∈ (-∞,∞)
     * @var array
     */
    const PARAMETER_LIMITS = ['a' => '(-∞,∞)', 'b' => '(-∞,∞)'];
    /**
     * Distribution support bounds limits
     * x ∈ (-∞,∞)
     * @var array
     */
    const SUPPORT_LIMITS = ['x' => '(-∞,∞)'];
    /** @var float Lower Bound Parameter */
    protected $a;
    /** @var float Upper Bound Parameter */
    protected $b;
    /**
     * Constructor
     *
     * @param float $a lower bound parameter
     * @param float $b upper bound parameter
     *
     * @throws OutOfBoundsException
     */
    public function __construct($a, $b)
    {
        if ($b <= $a) {
            throw new OutOfBoundsException("b must be > a: Given a:{$a} and b:{$b}");
        }
        parent::__construct($a, $b);
    }
    /**
     * Continuous uniform distribution - probability desnsity function
     * https://en.wikipedia.org/wiki/Uniform_distribution_(continuous)
     *
     *         1
     * pdf = -----  for a ≤ x ≤ b
     *       b - a
     *
     * pdf = 0      for x < a, x > b
     *
     * @param float $x percentile
     *
     * @return float
     */
    public function pdf($x)
    {
        $a = $this->a;
        $b = $this->b;
        if ($x < $a || $x > $b) {
            return 0;
        }
        return 1 / ($b - $a);
    }
    /**
     * Continuous uniform distribution - cumulative distribution function
     * https://en.wikipedia.org/wiki/Uniform_distribution_(continuous)
     *
     * cdf = 0      for x < a
     *
     *       x - a
     * cdf = -----  for a ≤ x < b
     *       b - a
     *
     * cdf = 1      x ≥ b
     *
     * @param float $x percentile
     *
     * @return float
     */
    public function cdf($x)
    {
        $a = $this->a;
        $b = $this->b;
        if ($x < $a) {
            return 0;
        }
        if ($x >= $b) {
            return 1;
        }
        return ($x - $a) / ($b - $a);
    }
    /**
     * Mean of the distribution
     *
     *     a + b
     * μ = -----
     *       2
     *
     *
     * @return float
     */
    public function mean()
    {
        return ($this->a + $this->b) / 2;
    }
    /**
     * Median of the distribution
     *
     *     a + b
     * μ = -----
     *       2
     *
     *
     * @return float
     */
    public function median()
    {
        return ($this->a + $this->b) / 2;
    }
    /**
     * Mode of the distribution
     *
     * mode = any value in (a, b)
     *
     * @return float
     */
    public function mode()
    {
        return $this->a;
    }
    /**
     * Variance of the distribution
     *
     *      (b - a)²
     * σ² = --------
     *         12
     *
     * @return float
     */
    public function variance()
    {
        return pow($this->b - $this->a, 2) / 12;
    }
}