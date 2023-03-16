Minasm/Carbon
=============

Minasm/Carbon is a package that extends the functionality of the [citco/carbon](https://github.com/citco/carbon) package, which provides a wrapper for the [Carbon](https://github.com/briannesbitt/Carbon) date/time library with support for UK bank holidays.

Installation
------------

To install Minasm/Carbon, simply require it using [Composer](https://getcomposer.org/):

```
composer require minasm/carbon

```

Usage
-----

Minasm/Carbon provides a single method: `getBusinessDays()`. This method calculates the number of business days between two dates, excluding weekends and UK bank holidays. Here's how you can use it:

```
use Minasm\Carbon;

$startDate = '01/03/2023';
$endDate = '31/03/2023';

$businessDays = (new Carbon())->getBusinessDays($startDate, $endDate);

echo "There are $businessDays business days between $startDate and $endDate.";

```

The output of the above code will be:

```
There are 23 business days between 01/03/2023 and 31/03/2023.

```

The `getBusinessDays()` method takes three parameters:

- `$start` (string): the start date, in the format specified by the `$format` parameter (default is `'d/m/Y'`).
- `$end` (string): the end date, in the format specified by the `$format` parameter (default is `'d/m/Y'`).
- `$format` (string, optional): the format of the `$start` and `$end` parameters (default is `'d/m/Y'`).


Issues
------

If you encounter any bugs or have any feature requests, please submit them to the [GitHub issue tracker](https://github.com/minasm/carbon/issues).

License
-------

Minasm/Carbon is open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

