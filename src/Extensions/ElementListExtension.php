<?php


namespace A2nt\ElementalBasics\Extensions;

use SilverStripe\ORM\DataExtension;

class ElementListExtension extends DataExtension
{
    public function getControllerName()
    {
        return EmptyPageController::class;
    }
}
