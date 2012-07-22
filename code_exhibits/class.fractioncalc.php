<?php
/*
CLASS FractionListObj
    A fraction list object is instantiated with three pieces of data:  
    a numerator range, a denominator, and a number base.

PROPERTIES
    public:
        $base: number base (defaults to 10).
        $fraction: list of fraction objects (FractionObj).


METHODS
        
    PUBLIC __construct:  Object constructor.  Builds list of fraction objects.


    PRIVATE parse:  parses the numerator range and returns an array.  This is
    expected to be either one integer or else a starting and stopping integer.

*/
class FractionListObj {
    public $base, $fraction;

    public function __construct($num, $denom, $base)
    {
        list($num1, $num2) = $this->parse($num);
        if ($num2 >= $denom) { $num2 = $denom - 1; }
        $this->base = strlen($base) == 0 ? 10 : $base;
        if ($this->base != 10) {
            $num1 = base_convert($num1, $this->base, 10);
            $num2 = base_convert($num2, $this->base, 10);
            $denom = base_convert($denom, $this->base, 10);
        }

        for ($i = $num1; $i <= $num2; $i++) {
            $this->fraction[$i] = new FractionObj($i, $denom, $base);
        }
    }


    private function parse($n) {
        $nrange = array(); 
        if (preg_match("/^([0-9a-zA-Z]+)\s*-\s*([0-9a-zA-Z]+)$/", $n, $matches)) {
            $nrange[] = $matches[1]; 
            $nrange[] = $matches[2]; 
        }
        else {
            $nrange[] = $n;
            $nrange[] = $n;
        }
        return $nrange;
    }
}


/*
CLASS FractionObj
    A fraction object is instantiated with three pieces of data:  a numerator,
    a denominator, and a number base.

PROPERTIES
    private:
        $prime: array of prime numbers.

    public:
        $num: numerator.
        $denom: denominator.
        $reduced_num: reduced numerator.
        $reduced_denom: reduced denominator.
        $base: number base.
        $fraction: fraction description.
        $section_list: list of sections in a decimal expansion.  Sections are:
            non-repeating, initial repeating portion, repeating portion complement. 
        $decimal: decimal expansion.
        $decimal_places: number of decimal places in expansion.
        $repeating: number of repeating decimals in expansion.

    For example, if the fraction is 1/6 (base 10):
        $num: 1
        $denom: 6
        $reduced_num: 1
        $reduced_denom: 6
        $base: 10
        $fraction: 1 / 6
        $decimal_places: 2
        $repeating: 1
        $decimal: .16
        $section_list: ('1', '6', '');

    If the fraction is 3/6 (base 10):
        $num: 3
        $denom: 6
        $reduced_num: 1
        $reduced_denom: 2
        $base: 10
        $fraction: 3 / 6 (1 / 2) 
        $decimal_places: 1
        $repeating: 0
        $decimal: .5
        $section_list: ('5', '', '');

    If the fraction is 1/7 (base 10):
        $num: 1
        $denom: 7
        $reduced_num: 1
        $reduced_denom: 7
        $base: 10
        $fraction: 1 / 7
        $decimal_places: 6
        $repeating: 6
        $decimal: .142857
        $section_list: ('', '142', '857');

METHODS
        
    PUBLIC __construct:  Object constructor.  Sets the public properties
    directly, or else calls the methods that sets them.


    PRIVATE calc_decimal:  Calculate the decimal expansion for the specified 
    numerator, denominator, and base.  Calculation is performed using long-
    division, rather than relying on the computer's internal precision.  In 
    this way, the calculation can be performed to far more decimal places than 
    otherwise possible.


    PRIVATE count_non_repeating.  Calculate and return the number of decimal 
    places that do not repeat, or -1 if the fraction resolves.  The number of 
    non-repeating decimal places is calculated by comparing the denominator's 
    prime factors with those of the number base.


    PRIVATE function get_gcf:  Calculate and return the greatest common factor 
    of two integers.

*/
class FractionObj {
    public $num, $denom, $reduced_num, $reduced_denom, $base, $fraction, $section_list, $decimal, $decimal_length, $repeating;
    private $primes = array(
        -1, 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97
    );


    public function __construct($num, $denom, $base)
    {
        $this->num = $num;
        $this->denom = $denom;
        $gcf = $this->get_gcf($num, $denom);  // GCF of numerator and denominator, for ensuring a reduced fraction.
        $this->reduced_num = $num / $gcf;
        $this->reduced_denom = $denom / $gcf;
        $this->base = $base;
        if ($this->reduced_denom < $this->denom) {
            $this->fraction = "$this->num / $this->denom ($this->reduced_num / $this->reduced_denom)";
        }
        else {
            $this->fraction = "$this->reduced_num / $this->reduced_denom";
        }
        // calc_decimal sets three additional properties:  decimal_length, repeating, and decimal.
        $this->calc_decimal();
    }


    private function calc_decimal() {
        // (Due to the complexity of the process, this method is copiously commented; hopefully this will clarify rather than obfuscate.)

        // ----- BEGIN INITIALIZATION -----
        // $section_list is a list of the decimal expansion's sections; to be imploded at the end of the calc_decimal method.  
        // The possible sections are:
        //   non-repeating portion,
        //   initial repeating portion,
        //   repeating portion complement. 
        // Examples:
        //   1/2 = .5.  Non-repeating portion: 5; no repeating portions.
        //   1/6 = .1666...  Non-repeating portion: 1; initial repeating portion: 6; no repeating portion complement.
        //   1/7 = .142857...  No non-repeating potion; initial repeating portion: 142; repeating potion complement: 857.
        $section_list = array('', '', '');
        $section_ndx = 0;

        // Call the count_non_repeating method to determine the number of non-repeating digits in the decimal expansion.
        // If the fraction resolves (i.e., has no repeating portion), the count_non_repeating method returns -1.
        $non_repeating = $this->count_non_repeating();
        // If a decimal expansion repeats, non_repeating_tally is used to detect the position at which the repetition begins.
        // If there is no repetition, non_repeating_tally is set to one less than the denominator, which is a position at or beyond the decimal expansion's maximum possible length.
        // Examples:  1/3 = .33333...  The whole thing repeats, so non_repeating_tally is 0.
        //            1/4 = .25  The fraction resolves.  non_repeating_tally is one 3.
        //            1/6 = .1666...  Only the 6's repeat, so non_repeating_tally is 1.
        $non_repeating_tally = $non_repeating == -1 ? $this->reduced_denom - 1 : $non_repeating;
        // The remainder_flag array contains one element for every possible remainder of a division involving the denominator.  This means the number of elements is one less than the denominator.
        $remainder_flag_list = array_fill(1, $this->reduced_denom - 1, false);
        $repeating_decimal_flag = $non_repeating != -1;
        $start_repeat = 0;
        $step_digit = 0;
        $step_remainder = $this->reduced_num;
        $decimal_length = 0;
        $linelength = 54;
        // ----- END INITIALIZATION -----

        // ----- BEGIN LONG DIVISION -----
        // Continue the process as long as both of two conditions are true:
        //   a) there is a remainder,
        //   b) the current remainder ($step_remainder) has not yet been encountered.
        while ($step_remainder != 0 && !$remainder_flag_list[$step_remainder]) {
            // Mark the current remainder in the remainder flag list.
            // While a decimal expansion can easily contain multiple instances of a certain digit, each possible remainder can occur only once.
            // This means that if the process encounters a given remainder for a second time, it's begun to repeat itself; ergo, the process is finished.
            $remainder_flag_list[$step_remainder] = true;
            // This is where you add a zero to the number you're dividing and then see how many times the divisor goes into it.
            // The number of times is called "step_digit" because, of course, this is the digit that results from this step of the process.
            // The step_digits are concatenated at each step, so that the final string is the decimal expansion.
            $step_digit = floor($step_remainder * $this->base / $this->reduced_denom);
            // Check for the end of the non-repeating portion of the decimal.
            if ($decimal_length == $non_repeating_tally) {
                $section_ndx++;
                $start_repeat = $step_remainder;  // Store this digit; it'll be used to determine when/if the complement begins.
            }
            // Append the current digit to the decimal expansion.  Perform base conversion if not in base 10.
            $section_list[$section_ndx] .= ($this->base != 10 ? base_convert($step_digit, 10, $this->base) : $step_digit);
            // This is where you find the remainder in the current step of the division.
            // Example:  for 1/4, the first step would entail multiplying the 1 by 10 and determining how many times 4 divides the result.  Since 4 goes into 10 twice,
            //           the "step_digit" value is 2.  Since 10 - 8 is 2, the "step_remainder" value is 2.
            $step_remainder = $step_remainder * $this->base - $step_digit * $this->reduced_denom;
            // Here's where we detect the repeating portion's complement.  
            // If in the course of calculating the decimal expansion one encounters two remainders whose sum is the denominator, 
            // then repeating portion can be split into two halves, and the sum of the two halves will be one less than an integer power of the number base.
            // For instance, in base 10, 1/7 = .142857...  The first remainder is 1 (the numerator), and the third remainder is 6.  The two halves, 142 and 857,
            // add up to 999, which is 10^3 - 1. 
            if ($step_remainder + $start_repeat == $this->reduced_denom) {
                $section_ndx++;
            }
            $decimal_length++;
            // This just checks to see if the decimal expansion has more digits than we want to display on a single line.  If so, an HTML line break is included.
            // ...and we're not going to do this here.  The br, if needed, should be inserted by whatever outputs the thing.
            /*
            if (is_int($decimal_length / $linelength)) {
                $section_list[$section_ndx] .= '<br />';
            }
            */
        }
        // ----- END LONG DIVISION -----

        // If the fraction evaluates to a repeating decimal, calculate the number of digits that repeat; otherwise, set it to 'None'.
        $repeating = $repeating_decimal_flag ? $decimal_length - $non_repeating_tally : 'None';

        // Decorate the sections (optional)
//        $section_list[0] = '<span class="non_repeating">' . $section_list[0] . '</span>';
//        $section_list[1] = '<span class="initial_repeat">' . $section_list[1] . '</span>';
//        $section_list[2] = '<span class="complement_repeat">' . $section_list[2] . '</span>';

        // Set properties determined by this method.
        $this->decimal_length = $decimal_length;
        $this->repeating = $repeating;
        $this->section_list = $section_list;
        $this->decimal = '.' . implode($section_list);
    }


    private function count_non_repeating() {
        $base_factor_tally = 0;
        $base_tmp = $this->base;
        $denom_tmp = $this->reduced_denom;
        $max_non_repeat_tally = 0;
        $non_repeat_tally = 0;
        $prime_ndx = 1;
        $retval = 0;

        // Loop through the prime number list, starting with 2 and continuing through the largest prime factor of the number base.
        while ($this->primes[$prime_ndx] <= $base_tmp) {
            // $non_repeat_tally must be initialized to 0 for each prime number in the cycle, so that the maximum tally can be determined.
            $non_repeat_tally = 0;
            $base_factor_tally = 0;
            // First, tally the occurrences of the present prime number in the base's set of factors.
            while (is_int($base_tmp / $this->primes[$prime_ndx])) {
                $base_tmp /= $this->primes[$prime_ndx];
                $base_factor_tally++;
            }      
            // If the present prime is indeed a factor of the base, process this block.
            if ($base_factor_tally > 0) {
                // This block will determine the number of non-repeating decimal places generated for the current prime number.  The maximum value from this will be returned.
                $prime_power = pow($this->primes[$prime_ndx], $base_factor_tally);
                // First, divide out all complete sets of the present prime number from the denominator, and tally the number of divisions.
                while (is_int($denom_tmp / $prime_power)) {
                    $denom_tmp /= $prime_power;
                    $non_repeat_tally++;
                }
                // Second, check for any remaining instances of the prime number.  If there are any, increment the tally, and divide out all that remain.
                if (is_int($denom_tmp / $this->primes[$prime_ndx])) {
                    $non_repeat_tally++;
                    while (is_int($denom_tmp / $this->primes[$prime_ndx])) {
                        $denom_tmp /= $this->primes[$prime_ndx];
                    }
                }
                // Keep the $max_non_repeat_tally up-to-date.
                $max_non_repeat_tally = max($non_repeat_tally, $max_non_repeat_tally);
            }
            $prime_ndx++;
        }
        // If $denom_tmp is equal to 1 at this point, the denominator's prime factors are all included in the set of factors for the base, which means the decimal resolves.
        // If the denominator has no factors in common with the base, then there are no non-repeating digits.
        $retval = $denom_tmp == 1 ? -1 : $max_non_repeat_tally;
        return $retval;
    }


    private function get_gcf($int1, $int2) {
        $ints = array($int1, $int2);

        $finished = false;
        while (!$finished) {
            $ints = array(max($ints), min($ints));
            if (is_int($ints[0] / $ints[1])) {
                $finished = true;
            } else {
                $ints[0] = $ints[0] - $ints[1];
            }
        }
        return $ints[1];
    }


}
?>
