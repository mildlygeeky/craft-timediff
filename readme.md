# Craft Time Diff

Craft Time Diff brings in the Twig Date Extension.

## Installation

* Place the **timediff** folder inside your **craft/plugins/** folder.
* Go to **settings/plugins** and install timediff

## Usage

The plugin adds the Twig time_diff filter (http://twig.sensiolabs.org/doc/extensions/date.html).

### Time Diff

Renders the difference between a date and now:

    {{ post.published_at|time_diff }}

    Outputs "1 day ago" or "in 5 months"

### Translations

Need to translate into other languages? Version 1.1 adds a simplistic delimited string that can be
split into an array, and uses Craft's built-in translation string where available:

    {{ post.published_at|time_diff_array }}

    Outputs "past|1|day" or "future|5|months" 

This could then be turned into an array with Twig's split filter:

    {% set diffArray = post.published_at|time_diff_array|split('|') %}

The array's first element will be either the word "past" or "future" (not translated), the second
element is the number of units, the third is the unit name (translated in plural or singular if available).

## Credits

* SensioLabs for writing the Date Extension
