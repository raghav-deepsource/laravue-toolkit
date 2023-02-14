<?php

namespace Laravue\Utility\CrawlerDetector;

/**
 * Trait ExclusionList
 */
trait ExclusionList
{
    /**
     * List of strings to remove from the user agent before running the crawler regex
     * Over a large list of user agents, this gives us about a 55% speed increase!
     */
    protected array $exclusions = [
        'Safari.[\d\.]*',
        'Firefox.[\d\.]*',
        ' Chrome.[\d\.]*',
        'Chromium.[\d\.]*',
        'MSIE.[\d\.]',
        'Opera\/[\d\.]*',
        'Mozilla.[\d\.]*',
        'AppleWebKit.[\d\.]*',
        'Trident.[\d\.]*',
        'Windows NT.[\d\.]*',
        'Android [\d\.]*',
        '\(?Macintosh.',
        'Ubuntu',
        'Linux',
        '[ ]Intel',
        'Mac OS X [\d_.,]*;?',
        '(like )?Gecko(.[\d\.]*)?',
        'KHTML,',
        'CriOS.[\d\.]*',
        'CPU iPhone OS ([0-9_])* like Mac OS X',
        'CPU OS ([0-9_])* like Mac OS X',
        'iPod',
        'compatible',
        'x86_..',
        'i686',
        'x64',
        'X11',
        'rv:[\d\.]*\)?',
        'Version.[\d\.]*',
        'WOW64',
        'Win64',
        'Dalvik.[\d\.]*',
        ' \.NET CLR [\d\.]*',
        'Presto.[\d\.]*',
        'Media Center PC',
        'BlackBerry',
        'Build',
        'Opera Mini\/\d{1,2}\.\d{1,2}\.[\d\.]*\/\d{1,2}\.',
        'Opera',
        ' \.NET[\d\.]*',
        'cubot',
        '; M bot',
        '; CRONO',
        '; B bot',
        '; IDbot',
        '; ID bot',
        '; POWER BOT',
        'OCTOPUS-CORE',
    ];

    protected function getExclusionRegex(): string
    {
        return '/('.implode('|', $this->exclusions).')/i';
    }
}
