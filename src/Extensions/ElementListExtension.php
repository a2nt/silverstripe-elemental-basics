<?php

namespace A2nt\ElementalBasics\Extensions;

use SilverStripe\ORM\DataExtension;
use A2nt\ElementalBasics\Elements\EmptyPageController;

class ElementListExtension extends DataExtension
{
    public function getControllerName()
    {
        return EmptyPageController::class;
    }
}
