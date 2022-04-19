<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/23/18
 * Time: 1:23 PM
 */

namespace A2nt\ElementalBasics\Extensions;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\ValidationResult;

class SlideImageEx extends DataExtension
{
    /*public function onBulkUpload()
    {
        die('saadsadssdsda2222');
    }

    public function validate(ValidationResult $validationResult)
    {
        if (!$this->owner->Name) {
            $this->owner->Name = rand();
        }
    }*/
}
