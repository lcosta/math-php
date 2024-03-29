<?php

namespace MathPHP\Number;

use MathPHP\Algebra;
use MathPHP\Exception;
use MathPHP\Functions\Special;
/**
 * Rational Numbers
 *
 * https://en.wikipedia.org/wiki/Rational_number
 * A rational number can be expressed as a fraction. Using the rational number object allows a user to
 * express non-integer values with exact precision, and perform arithmetic without floating point
 * errors.
 */
class Rational implements ObjectArithmetic
{
    /** @var int Whole part of the number */
    protected $whole;
    /** @var int Numerator part of the fractional part */
    protected $numerator;
    /** @var int Denominator part of the fractional part */
    protected $denominator;
    /**
     * Constructor
     *
     * @todo  How to handle negative numbers in various positions.
     * @param int $w whole part
     * @param int $n numerator part
     * @param int $d
     */
    public function __construct($w, $n, $d)
    {
        list($w, $n, $d) = self::normalize($w, $n, $d);
        $this->whole = $w;
        $this->numerator = $n;
        $this->denominator = $d;
    }
    /**
     * String representation of a rational number
     * 5 6/7, 456079/13745859, etc.
     *
     * @return string
     */
    public function __toString()
    {
        $sign = '';
        $whole = '';
        $fraction = '';
        if (Special::sgn($this->whole) === -1 || Special::sgn($this->numerator) === -1) {
            $sign = '-';
        }
        if ($this->whole !== 0) {
            $whole = abs($this->whole);
        }
        if ($this->numerator !== 0) {
            if ($this->whole !== 0) {
                $whole .= ' ';
            }
            $fraction = $this->numeratorToSuperscript() . '/' . $this->denominatorToSubscript();
        }
        $string = $sign . $whole . $fraction;
        if ($string == '') {
            $string = '0';
        }
        return $string;
    }
    /**
     * Convert the numerator to superscript character
     *
     * @return string
     */
    private function numeratorToSuperscript()
    {
        return $this->toSuperOrSubscript(abs($this->numerator), ['⁰', '¹', '²', '³', '⁴', '⁵', '⁶', '⁷', '⁸', '⁹']);
    }
    /**
     * Convert the denominator to subscript character
     *
     * @return string
     */
    private function denominatorToSubscript()
    {
        return $this->toSuperOrSubscript($this->denominator, ['₀', '₁', '₂', '₃', '₄', '₅', '₆', '₇', '₈', '₉']);
    }
    /**
     * Convert a character to an alternate script (super or subscript)
     *
     * @param int   $i     number to convert
     * @param array $chars conversion character map
     *
     * @return string
     */
    private function toSuperOrSubscript($i, array $chars)
    {
        $return_string = '';
        $number_of_chars = floor(log10($i) + 1);
        $working_value = $i;
        for ($j = $number_of_chars - 1; $j >= 0; $j--) {
            $int = intdiv($working_value, 10 ** $j);
            $return_string .= $chars[$int];
            $working_value -= $int * 10 ** $j;
        }
        return $return_string;
    }
    /**
     * Rational number as a float
     *
     * @return float
     */
    public function toFloat()
    {
        $frac = $this->numerator / $this->denominator;
        $sum = $this->whole + $frac;
        return $sum;
    }
    /**************************************************************************
     * UNARY FUNCTIONS
     **************************************************************************/
    /**
     * The absolute value of a rational number
     *
     * @return Rational
     */
    public function abs()
    {
        return new Rational(abs($this->whole), abs($this->numerator), abs($this->denominator));
    }
    /**************************************************************************
     * BINARY FUNCTIONS
     **************************************************************************/
    /**
     * Addition
     *
     * @param Rational|int $r
     *
     * @return Rational
     *
     * @throws Exception\IncorrectTypeException if the argument is not numeric or Rational.
     */
    public function add($r)
    {
        if (is_int($r)) {
            return $this->addInt($r);
        } elseif ($r instanceof Rational) {
            return $this->addRational($r);
        } else {
            throw new Exception\IncorrectTypeException('Argument must be an integer or RationalNumber');
        }
    }
    /**
     * Add an integer
     *
     * @param int $int
     *
     * @return Rational
     */
    private function addInt($int)
    {
        $w = $this->whole + $int;
        return new Rational($w, $this->numerator, $this->denominator);
    }
    /**
     * Add a rational number
     *
     * @param Rational $r
     *
     * @return Rational
     */
    private function addRational(Rational $r)
    {
        $w = $this->whole;
        $n = $this->numerator;
        $d = $this->denominator;
        $rn = $r->numerator;
        $rd = $r->denominator;
        $rw = $r->whole;
        $w += $rw;
        $lcm = Algebra::lcm($d, $rd);
        $n = $n * intdiv($lcm, $d) + $rn * intdiv($lcm, $rd);
        $d = $lcm;
        return new Rational($w, $n, $d);
    }
    /**
     * Subtraction
     *
     * @param Rational|int $r
     *
     * @return Rational
     *
     * @throws Exception\IncorrectTypeException if the argument is not numeric or Rational.
     */
    public function subtract($r)
    {
        if (is_int($r)) {
            return $this->add(-1 * $r);
        } elseif ($r instanceof Rational) {
            return $this->add($r->multiply(-1));
        } else {
            throw new Exception\IncorrectTypeException('Argument must be an integer or RationalNumber');
        }
    }
    /**
     * Multiply
     * Return the result of multiplying two rational numbers, or a rational number and an integer.
     *
     * @param Rational|int $r
     *
     * @return Rational
     *
     * @throws Exception\IncorrectTypeException if the argument is not numeric or Rational.
     */
    public function multiply($r)
    {
        if (is_int($r)) {
            return $this->multiplyInt($r);
        } elseif ($r instanceof Rational) {
            return $this->multiplyRational($r);
        } else {
            throw new Exception\IncorrectTypeException('Argument must be an integer or RationalNumber');
        }
    }
    /**
     * Multiply an integer
     *
     * @param int $int
     *
     * @return Rational
     */
    private function multiplyInt($int)
    {
        $w = $this->whole * $int;
        $n = $this->numerator * $int;
        return new Rational($w, $n, $this->denominator);
    }
    /**
     * Multiply a rational number
     *
     * @param Rational $r
     *
     * @return Rational
     */
    private function multiplyRational(Rational $r)
    {
        $w = $this->whole;
        $n = $this->numerator;
        $d = $this->denominator;
        $w2 = $r->whole;
        $n2 = $r->numerator;
        $d2 = $r->denominator;
        $new_w = $w * $w2;
        $new_n = $w * $n2 * $d + $w2 * $n * $d2 + $n2 * $n;
        $new_d = $d * $d2;
        return new Rational($new_w, $new_n, $new_d);
    }
    /**
     * Divide
     * Return the result of dividing two rational numbers, or a rational number by an integer.
     *
     * @param Rational|int $r
     *
     * @return Rational
     *
     * @throws Exception\IncorrectTypeException if the argument is not numeric or Rational.
     */
    public function divide($r)
    {
        if (is_int($r)) {
            return $this->divideInt($r);
        } elseif ($r instanceof Rational) {
            return $this->divideRational($r);
        } else {
            throw new Exception\IncorrectTypeException('Argument must be an integer or RationalNumber');
        }
    }
    /**
     * Divide by an integer
     *
     * @param int $int
     *
     * @return Rational
     */
    private function divideInt($int)
    {
        $w = $this->whole;
        $n = $this->numerator;
        $d = $this->denominator;
        return new Rational(0, $w * $d + $n, $int * $d);
    }
    /**
     * Divide by a rational number
     *
     * @param Rational $r
     *
     * @return Rational
     */
    private function divideRational(Rational $r)
    {
        $w = $this->whole;
        $n = $this->numerator;
        $d = $this->denominator;
        $w2 = $r->whole;
        $n2 = $r->numerator;
        $d2 = $r->denominator;
        $new_w = 0;
        $new_n = $d2 * ($w * $d + $n);
        $new_d = $d * ($w2 * $d2 + $n2);
        return new Rational($new_w, $new_n, $new_d);
    }
    /**************************************************************************
     * COMPARISON FUNCTIONS
     **************************************************************************/
    /**
     * Test for equality
     *
     * Two normalized RationalNumbers are equal IFF all three parts are equal.
     *
     * @param Rational $rn
     *
     * @return bool
     */
    public function equals(Rational $rn)
    {
        return $this->whole == $rn->whole && $this->numerator == $rn->numerator && $this->denominator == $rn->denominator;
    }
    /**
     * Normalize the input
     *
     * We want to ensure that the format of the data in the object is correct.
     * We will ensure that the numerator is smaller than the denominator, the sign
     * of the denominator is always positive, and the signs of the numerator and
     * whole number match.
     *
     * @param int $w whole number
     * @param int $n numerator
     * @param int $d denominator
     *
     * @return array
     */
    private function normalize($w, $n, $d)
    {
        if ($d == 0) {
            throw new Exception\BadDataException('Denominator cannot be zero');
        }
        // Make sure $d is positive
        if ($d < 0) {
            $n *= -1;
            $d *= -1;
        }
        // Reduce the fraction
        if (abs($n) >= $d) {
            $w += intdiv($n, $d);
            $n = $n % $d;
        }
        $gcd = 0;
        while ($gcd != 1 && $n !== 0) {
            $gcd = abs(Algebra::gcd($n, $d));
            $n /= $gcd;
            $d /= $gcd;
        }
        // Make the signs of $n and $w match
        if (Special::sgn($w) !== Special::sgn($n) && $w !== 0 && $n !== 0) {
            $w = $w - Special::sgn($w);
            $n = ($d - abs($n)) * Special::sgn($w);
        }
        if ($n == 0) {
            $d = 1;
        }
        return [$w, $n, $d];
    }
}