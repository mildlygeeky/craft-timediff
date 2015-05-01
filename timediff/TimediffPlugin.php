<?php
namespace Craft;

class TimediffPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Time Diff');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Mildly Geeky';
    }

    function getDeveloperUrl()
    {
        return 'http://mildlygeeky.com';
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.timediff.twigextensions.Date', true);
        return new TwigExtensionDate();
    }
}
