<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;

use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextareaField;

/**
 * Class \A2nt\ElementalBasics\Elements\CustomSnippetElement
 *
 */
class CustomSnippetElement extends ElementContent
{
    private static $icon = 'font-icon-external-link';
    private static $singular_name = 'Custom Snippet';

    private static $plural_name = 'Custom Snippets';

    private static $description = 'Displays Custom Snippet';

    private static $table_name = 'CustomSnippetElement';

    public function getType()
    {
        return self::$singular_name;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField(
            'HTML',
            TextareaField::create('HTML')
        );

        return $fields;
    }
}
