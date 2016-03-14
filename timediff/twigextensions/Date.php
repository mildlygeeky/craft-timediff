<?php
namespace Craft;

/**
 * This file is part of Twig.
 *
 * (c) 2014 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

/**
 * @author Robin van der Vleuten <robinvdvleuten@gmail.com>
 */
class TwigExtensionDate extends \Twig_Extension
{
    public $units_translated = array();

    static $units = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    function __construct()
    {
        $this->units_translated = array(
            'y' => Craft::t('year'),
            'm' => Craft::t('month'),
            'd' => Craft::t('day'),
            'h' => Craft::t('hour'),
            'i' => Craft::t('minute'),
            's' => Craft::t('second'),
        );
    }

    /**
     * Returns a list of filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time_diff', array($this, 'diff'), array(
                'needs_environment' => true
            )),
            new \Twig_SimpleFilter('time_diff_array', array($this, 'diff_array'), array(
                'needs_environment' => true
            )),
        );
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'date';
    }

    /**
     * Filter for converting dates to a time ago string like Facebook and Twitter has.
     *
     * @param Twig_Environment $env  A Twig_Environment instance.
     * @param string|DateTime  $date A string or DateTime object to convert.
     * @param string|DateTime  $now  A string or DateTime object to compare with. If none given, the current time will be used.
     *
     * @return string The converted time.
     */
    public function diff(\Twig_Environment $env, $date, $now = null)
    {
        // Convert both dates to DateTime instances.
        $date = twig_date_converter($env, $date);
        $now = twig_date_converter($env, $now);

        // Get the difference between the two DateTime objects.
        $diff = $date->diff($now);

        // Check for each interval if it appears in the $diff object.
        foreach (self::$units as $attribute => $unit) {
            $count = $diff->$attribute;

            if (0 !== $count) {
                return $this->getPluralizedInterval($count, $diff->invert, $unit);
            }
        }

        return '';
    }

    /**
     * Filter for converting dates to a time ago string like Facebook and Twitter has, in a translatable array
     *
     * @param Twig_Environment $env  A Twig_Environment instance.
     * @param string|DateTime  $date A string or DateTime object to convert.
     * @param string|DateTime  $now  A string or DateTime object to compare with. If none given, the current time will be used.
     *
     * @return string The converted time.
     */
    public function diff_array(\Twig_Environment $env, $date, $now = null)
    {
        // Convert both dates to DateTime instances.
        $date = twig_date_converter($env, $date);
        $now = twig_date_converter($env, $now);

        // Get the difference between the two DateTime objects.
        $diff = $date->diff($now);

        // Check for each interval if it appears in the $diff object.
        foreach ($this->units_translated as $attribute => $unit) {
            $count = $diff->$attribute;

            if (0 !== $count) {
                return $this->getPluralizedIntervalArray($count, $diff->invert, $unit);
            }
        }

        return '';
    }

    protected function getPluralizedInterval($count, $invert, $unit)
    {

        if ($count > 1) {
            $unit .= 's';
        }

        return $invert ? "in $count $unit" : "$count $unit ago";
    }

    protected function getPluralizedIntervalArray($count, $invert, $unit)
    {
        $translateable_array = array($invert ? 'future' : 'past', $count, $unit, $count > 1 ? 'plural' : 'single');
        return implode('|', $translateable_array);
    }

}
