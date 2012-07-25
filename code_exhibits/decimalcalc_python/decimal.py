#
#   Decimal class.  This class is used to perform and analyze the long division
#       for generating the decimal expansions for fractions having a specified
#       denominator.  The number base can also be specified, though it defaults
#       to base 10.  The resulting data include:
#
#       fraction: e.g., "1/7"
#       decimal: the decimal expansion; e.g., "142857"
#       decimal_parts: a three-element array, containing the various parts of
#           the decimal expansion.  These parts are described below.
#       length: the length of the decimal expansion; e.g., 6
#       halfway: if applicable, the position in the repeating portion of the
#           decimal expansion after which the complementary portion begins.
#           E.g., 3
#       resolves: True / False, depending on whether the decimal expansion
#           eventually terminates.  E.g., True for 1/2; False for 1/3.
#       non_repeating: if applicable, the length of the non-repeating portion
#           of the decimal expansion.  E.g., for 1/2, the length is 1; for 1/3,
#           the length is 0-; for 1/12, the length is 2.
#

class Decimal:
    primes = (2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97)

    def __init__(self, denom, base=10):
        denom = int(denom)
        self.base = int(base)
        data = []
        for i in range(1, denom):
            data.append(self._get_decimal_data(i, denom))
        self.denominator = denom
        self.data = data


    def _get_decimal_data(self, num, denom):
        decimal_parts = []
        remainder = num
        halfway = 0
        resolves = False
        non_repeating = 0
        places = []
        remainders = [remainder]
        period_complete = False
        while not period_complete:

            # Perform the steps of long division until period is complete.

            if remainder < denom:
                remainder *= self.base
            place = remainder / denom
            places.append(place)
            remainder -= place * denom

            # Check for period completion.

            # Period is complete if long division resolves without remainder.
            if remainder == 0:
                period_complete = True
                resolves = True
                decimal_parts = [''.join(map(str,places)), '', '']

            # Period is complete if a remainder is repeated.
            elif remainder in remainders:
                period_complete = True
                resolves = False
                non_repeating = remainders.index(remainder)
                if (len(places) - non_repeating) % 2 == 0:
                    halfway = non_repeating + len(places) / 2
                else:
                    halfway = len(places)
                decimal_parts = [
                    ''.join(map(str,places[0:non_repeating])),
                    ''.join(map(str,places[non_repeating:halfway])),
                    ''.join(map(str,places[halfway:]))
                ]

            # Store the remainder if resolution not detected.
            else:
                remainders.append(remainder)

        # Once the decimal expansion is complete, compile the data.
        decimal_data = {
            'fraction'      : str(num) + '/' + str(denom),
            'decimal'       : ''.join(map(str,places)),
            'decimal_parts' : decimal_parts,
            'length'        : len(places),
            'halfway'       : halfway,
            'resolves'      : resolves,
            'non_repeating' : non_repeating
        }

        return decimal_data

