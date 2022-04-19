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
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\ValidationResult;

class SlideImageEx extends DataExtension
{
      private static $db = [
        'Hide' => 'Boolean(0)',
        'DateOn' => 'Datetime',
        'DateOff' => 'Datetime',
    ];

     private $_cache = [
         'element' => [],
     ];

     public function getElement()
    {
        if(!isset($this->_cache['element'][$this->owner->ID])) {
            $this->_cache['element'][$this->owner->ID] = $this->owner->SlideshowElement();
        }

        return $this->_cache['element'][$this->owner->ID];
    }


    public function ImageURL()
    {
        $el = $this->getElement();
        $img = $this->owner->Image();

        if(!$img) {
            return null;
        }

        if($el->getField('ImageOriginalSize')){
            return $img->Link();
        }

        return $img->FocusFill($this->getSlideWidth(), $this->getSlideHeight())->Link();
    }

    public function getSlideWidth()
    {
        $element = $this->getElement();
        if(!$element->ID) {
        	return SliderElement::config()->get('slide_width');
        }

        return $element->getSlideWidth();
    }

    public function getSlideHeight()
    {
        $element = $this->getElement();
        if(!$element->ID) {
        	return SliderElement::config()->get('slide_height');
        }

        return $element->getSlideHeight();
    }

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $fields->removeByName([
            'PageLinkID',
            'Hide',
            'DateOn',
            'DateOff',
        ]);


        $fields->dataFieldByName('Image')
            ->setTitle('Image ('.$this->getSlideWidth().' x '.$this->getSlideHeight().' px)');

        $fields->addFieldToTab('Root.Main', ToggleCompositeField::create(
            'ConfigHD',
            'Slide Settings',
            [
                CheckboxField::create('Hide', 'Hide this slide? (That will hide the slide regardless of start/end fields)'),
                DatetimeField::create('DateOn', 'When would you like to start showing the slide?'),
                DatetimeField::create('DateOff', 'When would you like to stop showing the slide?'),
            ]
        ));
    }

    public function validate(ValidationResult $validationResult)
    {
        if (!$this->owner->Name) {
            $this->owner->Name = rand();
        }
    }
}
