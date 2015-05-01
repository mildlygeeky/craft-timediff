# Craft Time Diff

Craft Time Diff brings in the Twig Date Extension.

## Installation

* Place the **time-diff** folder inside your **craft/plugins/** folder.
* Go to **settings/plugins** and install time-diff

## Usage

The plugin adds the Twig time_diff filter (http://twig.sensiolabs.org/doc/extensions/date.html).

### Time Diff

Renders the difference between a date and now.

    {{ post.published_at|time_diff }}

## Credits

* SensioLabs for writing the Date Extension
