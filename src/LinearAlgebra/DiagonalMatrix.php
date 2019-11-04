<?php

namespace MathPHP\LinearAlgebra;

use MathPHP\Exception\MatrixException;
/**
 * Diagonal matrix
 * Elements along the main diagonal are the only non-zero elements (may also be zero).
 * The off-diagonal elements are all zero
 */
class DiagonalMatrix extends SquareMatrix
{
    /**
     * Constructor
     *
     * @param array $A
     */
    public function __construct(array $A)
    {
        parent::__construct($A);
        if (!parent::isLowerTriangular() || !parent::isUpperTriangular()) {
            throw new MatrixException('Trying to construct DiagonalMatrix with non-diagonal elements: ' . print_r($this->A, true));
        }
    }
    /**
     * Diagonal matrix must be symmetric
     * @inheritDoc
     */
    public function isSymmetric()
    {
        return true;
    }
    /**
     * Diagonal matrix must be lower triangular
     * @inheritDoc
     */
    public function isLowerTriangular()
    {
        return true;
    }
    /**
     * Diagonal matrix must be upper triangular
     * @inheritDoc
     */
    public function isUpperTriangular()
    {
        return true;
    }
    /**
     * Diagonal matrix must be triangular
     * @inheritDoc
     */
    public function isTriangular()
    {
        return true;
    }
    /**
     * Diagonal matrix must be diagonal
     * @inheritDoc
     */
    public function isDiagonal()
    {
        return true;
    }
}