<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;

use Colymba\BulkUpload\BulkUploader;
use Dynamic\Elements\Flexslider\Elements\ElementSlideshow;
use Dynamic\FlexSlider\Model\SlideImage;
use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField_ActionMenu;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\ReadonlyField;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

/**
 * Class \A2nt\ElementalBasics\Elements\SliderElement
 *
 * @property string $Animation
 * @property boolean $Loop
 * @property boolean $Animate
 * @property boolean $ThumbnailNav
 * @property boolean $SliderControlNav
 * @property boolean $SliderDirectionNav
 * @property boolean $CarouselControlNav
 * @property boolean $CarouselDirectionNav
 * @property int $CarouselThumbnailCt
 * @property float $FlexSliderSpeed
 * @property int $Interval
 * @property int $SlidesInRow
 * @property boolean $ImageOriginalSize
 * @method \SilverStripe\ORM\DataList|\Dynamic\FlexSlider\Model\SlideImage[] Slides()
 * @mixin \Dynamic\FlexSlider\ORM\FlexSlider
 */
class SliderElement extends ElementSlideshow
{
    private static $singular_name = 'Slider';

    private static $plural_name = 'Sliders';

    private static $description = 'Displays slide show';

    private static $table_name = 'SliderElement';

    private static $slide_width = 2140;
    private static $slide_height = 700;

    private static $db = [
        'Interval' => 'Int',
        'SlidesInRow' => 'Int',
        'ImageOriginalSize' => 'Boolean(0)',
    ];

    private static $extensions = [
        FlexSlider::class,
    ];

    private static $owns = [
        'Slides',
    ];

    private $items;

    public function getType()
    {
        return self::$singular_name;
    }

    protected function ratioSize($size)
    {
        $count = $this->SlidesInRow;
        return ($count > 1) ? $size / $count : $size;
    }

    public function getSlideWidth()
    {
        if ($this->getField('ImageOriginalSize')) {
            return null;
        }

        return $this->ratioSize(self::config()->get('slide_width'));
    }

    public function getSlideHeight()
    {
        if ($this->getField('ImageOriginalSize')) {
            return null;
        }

        return $this->ratioSize(self::config()->get('slide_height'));
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // remove in case you don't need to provide this functionality
        $fields->removeByName([
            'ConfigHD',
            'Animation',
            'Loop',
            'Animate',
            'ThumbnailNav',
            'SliderControlNav',
            'SliderDirectionNav',
            'CarouselControlNav',
            'CarouselDirectionNav',
            'CarouselThumbnailCt',
        ]);

        $fields->addFieldsToTab('Root.Settings', [
            CheckboxField::create('ImageOriginalSize', 'Use original image size'),
            NumericField::create('Interval', 'Auto-play Interval (sec)'),
            NumericField::create('SlidesInRow'),
        ]);

        $grid = $fields->dataFieldByName('Slides');
        if ($grid) {
            $fields->insertBefore('Slides', LiteralField::create(
                'SlidesNote',
                '<div class="alert alert-info">Note: to show hidden slide open slide item and uncheck "Hide" checkbox</div>'
            ));

            $config = $grid->getConfig();
            $config->removeComponentsByType(GridField_ActionMenu::class);

            /*$bulk = new BulkUploader('Image', SlideImage::class, false);
            $bulk
                ->setUfSetup('setFolderName', 'Uploads/SlideImages');
            //->setUfSetup('getValidator.setAllowedExtensions', ['jpg', 'jpeg', 'png', 'gif']);
            $config->addComponent($bulk);*/
            $config->addComponent(new \Colymba\BulkManager\BulkManager());

            $columns = new GridFieldEditableColumns();
            $columns->setDisplayFields([
                    'Hide'  => [
                        'title' => 'Hide it?',
                        'field' => CheckboxField::class,
                    ],
                ]);

            $config->addComponent($columns);
        }

        return $fields;
    }

    /**
     * @return mixed
     */
    public function getSlideShow()
    {
        if ($this->items) {
            return $this->items;
        }

        $date = date('Y-m-d H:i:s');
        $this->items = $this->Slides()->filter([
            'Hide' => '0',
        ])->filterByCallback(static function ($item, $list) use ($date) {
            $on = $item->getField('DateOn');
            $off = $item->getField('DateOff');

            return ($on <= $date) && (!$off || $off > $date);
        })->sort('SortOrder');

        return $this->items;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->getField('Interval')) {
            $this->setField('Interval', 5000);
        }
    }
}
