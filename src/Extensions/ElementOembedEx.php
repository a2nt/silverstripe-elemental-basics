<?php

namespace A2nt\ElementalBasics\Extensions;

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataExtension;

class ElementOembedEx extends DataExtension
{
    private static $has_one = [
        'VideoFile' => File::class,
    ];

    private static $owns = [
        'VideoFile',
    ];
}
