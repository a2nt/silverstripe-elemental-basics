<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/23/18
 * Time: 1:23 PM
 */

namespace A2nt\ElementalBasics\Extensions;

use A2nt\ElementalBasics\Elements\SliderElement;
use Dynamic\FlexSlider\Model\SlideImage;
use LeKoala\FilePond\FilePondField;
use SilverStripe\Assets\File;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationResult;

/**
 * Class \A2nt\ElementalBasics\Extensions\SlideImageEx
 *
 * @property \A2nt\ElementalBasics\Extensions\SlideImageEx $owner
 * @property boolean $Hide
 * @property string $DateOn
 * @property string $DateOff
 */
class SlideImageEx extends DataExtension
{
    private static $db = [
        'Hide' => 'Boolean(0)',
        'DateOn' => 'Datetime',
        'DateOff' => 'Datetime',
    ];

    private static $has_one = [
        'VideoFile' => File::class,
    ];

    private static $owns = [
        'VideoFile',
    ];

    private $_cache = [
        'element' => [],
    ];

    public function getElement()
    {
        if (!isset($this->_cache['element'][$this->owner->ID])) {
            $this->_cache['element'][$this->owner->ID] = $this->owner->SlideshowElement();
        }

        return $this->_cache['element'][$this->owner->ID];
    }


    public function ImageURL()
    {
        $el = $this->getElement();
        $img = $this->owner->Image();

        if (!$img) {
            return null;
        }

        if ($el->getField('ImageOriginalSize')) {
            return $img->Link();
        }

        return $img->FocusFill($this->getSlideWidth(), $this->getSlideHeight())->Link();
    }

    public function getSlideWidth()
    {
        $element = $this->getElement();
        if (!$element->ID) {
            return SliderElement::config()->get('slide_width');
        }

        return $element->getSlideWidth();
    }

    public function getSlideHeight()
    {
        $element = $this->getElement();
        if (!$element->ID) {
            return SliderElement::config()->get('slide_height');
        }

        return $element->getSlideHeight();
    }

    public static function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
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

        $videoUpload = FilePondField::create('VideoFile')
            ->setChunkUploads(true)
            ->setAllowedExtensions(['mp4'])
            ->setFolderName('Uploads/SlideVideos');

        $validator = $videoUpload->getValidator();
        $validator->setAllowedMaxFileSize(['mp4' => Config::inst()->get(SlideImage::class, 'max_video_size')]);

        $maxFileSize = $validator->getAllowedMaxFileSize('mp4');
        $videoUpload->setTitle('Video File (max size: '.self::formatBytes($maxFileSize).')');

        $fields->insertAfter('Headline', $videoUpload);

        $fields->dataFieldByName('Image')
            ->setTitle('Image ('.$this->getSlideWidth().' x '.$this->getSlideHeight().' px)');

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('Hide', 'Hide this slide? (That will hide the slide regardless of start/end fields)'),
            ToggleCompositeField::create(
                'ConfigHD',
                'Slide Date Settings',
                [
                    DatetimeField::create('DateOn', 'When would you like to start showing the slide?'),
                    DatetimeField::create('DateOff', 'When would you like to stop showing the slide?'),
                ]
            )
        ]);
    }

    public function validate(ValidationResult $validationResult)
    {
        if (!$this->owner->Name) {
            $this->owner->Name = rand();
        }
    }
}
