<?php

namespace A2nt\ElementalBasics\Extensions;

use SilverStripe\ORM\DataExtension;
use A2nt\ElementalBasics\Elements\EmptyPageController;

/**
 * Class \A2nt\ElementalBasics\Extensions\ElementListExtension
 *
 * @property \A2nt\ElementalBasics\Extensions\ElementListExtension $owner
 */
class ElementListExtension extends DataExtension
{
    public function getControllerName()
    {
        return EmptyPageController::class;
    }
}
