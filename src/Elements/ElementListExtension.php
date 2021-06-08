<?php


namespace A2nt\ElementalBasics\Elements;


use SilverStripe\ORM\DataExtension;

class ElementListExtension extends DataExtension
{
    public function getControllerName()
    {
        return EmptyPageController::class;
    }
}
