<?php

namespace MathPHP\Statistics;

class Distribution
{
    const PRINT = true;
    /**
     * Frequency distribution
     * A table that displays the frequency of various outcomes in a sample.
     * Each entry in the table contains the frequency or count of the occurrences of values
     * within a particular group or interval.
     * The table summarizes the distribution of values in the sample.
     * https://en.wikipedia.org/wiki/Frequency_distribution
     *
     * The values of the input array will be the keys of the result array.
     * The count of the values will be the value of the result array for that key.
     *
     * @param array $values Ex: ( A, A, A, B, B, C )
     *
     * @return array frequency distribution Ex: ( A => 3, B => 2, C => 1 )
     */
    public static function frequency(array $values)
    {
        $frequencies = array();
        foreach ($values as $value) {
            if (!isset($frequencies[$value])) {
                $frequencies[$value] = 1;
            } else {
                $frequencies[$value]++;
            }
        }
        return $frequencies;
    }
    /**
     * Relative frequency distribution
     * Frequency distribution relative to the sample size.
     *
     * Relative Frequency = Frequency / Sample Size
     *
     * The values of the input array will be the keys of the result array.
     * The relative frequency of the values will be the value of the result array for that key.
     *
     * @param array $values Ex: ( A, A, A, A, A, A, B, B, B, C )
     *
     * @return array relative frequency distribution Ex: ( A => 0.6, B => 0.3, C => 0.1 )
     */
    public static function relativeFrequency(array $values)
    {
        $sample_size = count($values);
        $relative_frequencies = array();
        foreach (self::frequency($values) as $subject => $frequency) {
            $relative_frequencies[$subject] = $frequency / $sample_size;
        }
        return $relative_frequencies;
    }
    /**
     * Cumulative frequency distribution
     *
     * The values of the input array will be the keys of the result array.
     * The cumulative frequency of the values will be the value of the result array for that key.
     *
     * @param array $values Ex: ( A, A, A, A, A, A, B, B, B, C )
     *
     * @return array cumulative frequency distribution Ex: ( A => 6, B => 9, C => 10 )
     */
    public static function cumulativeFrequency(array $values)
    {
        $running_total = 0;
        $cumulative_frequencies = array();
        foreach (self::frequency($values) as $value => $frequency) {
            $running_total += $frequency;
            $cumulative_frequencies[$value] = $running_total;
        }
        return $cumulative_frequencies;
    }
    /**
     * Cumulative relative frequency distribution
     * Cumulative frequency distribution relative to the sample size.
     *
     * Cumulative relative frequency = cumulative frequency / sample size
     *
     * The values of the input array will be the keys of the result array.
     * The cumulative frequency of the values will be the value of the result array for that key.
     *
     * @param array $values Ex: ( A, A, A, A, A, A, B, B, B, C )
     *
     * @return array cumulative relative frequency distribution Ex: ( A => 0.6, B => 0.9, C => 1 )
     */
    public static function cumulativeRelativeFrequency(array $values)
    {
        $sample_size = count($values);
        $cumulative_frequencies = self::cumulativeFrequency($values);
        return array_map(function ($frequency) use($sample_size) {
            return $frequency / $sample_size;
        }, $cumulative_frequencies);
    }
    /**
     * Stem and leaf plot
     * Device for presenting quantitative data in a graphical format, similar to a histogram,
     * to assist in visualizing the shape of a distribution.
     * https://en.wikipedia.org/wiki/Stem-and-leaf_display
     *
     * Returns an array with the keys as the stems, and the values are arrays containing the leaves.
     *
     * Optional parameter to print the stem and leaf plot.
     * Given input array: [ 44 46 47 49 63 64 66 68 68 72 72 75 76 81 84 88 106 ]
     * Prints:
     *   4 | 4 6 7 9
     *   5 |
     *   6 | 3 4 6 8 8
     *   7 | 2 2 5 6
     *   8 | 1 4 8
     *   9 |
     *  10 | 6
     *
     * @param array $values
     * @param bool  $print  Optional setting to print the distribution
     *
     * @return array keys are the stems, values are the leaves
     */
    public static function stemAndLeafPlot(array $values, $print = false)
    {
        // Split each value into stem and leaf
        sort($values);
        $plot = array();
        foreach ($values as $value) {
            $stem = $value / 10;
            $leaf = $value % 10;
            if (!isset($plot[$stem])) {
                $plot[$stem] = array();
            }
            $plot[$stem][] = $leaf;
        }
        // Fill in any empty keys in the distribution we had no stem/leaves for
        $min = min(array_keys($plot));
        $max = max(array_keys($plot));
        for ($stem = $min; $stem <= $max; $stem++) {
            if (!isset($plot[$stem])) {
                $plot[$stem] = array();
            }
        }
        ksort($plot);
        // Optionally print the stem and leaf plot
        if ($print === true) {
            $length = max(array_map(function ($stem) {
                return strlen($stem);
            }, array_keys($plot)));
            foreach ($plot as $stem => $leaves) {
                printf("%{$length}d | %s\n", $stem, implode(' ', $leaves));
            }
        }
        return $plot;
    }
}