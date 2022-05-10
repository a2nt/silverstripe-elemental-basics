<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;

use DNADesign\ElementalList\Model\ElementList;
use SilverStripe\Forms\CheckboxField;

/**
 * Class \A2nt\ElementalBasics\Elements\AccordionElement
 *
 * @property boolean $OpenFirst
 * @property boolean $KeepOpenned
 */
class AccordionElement extends ElementList
{
    private static $icon = 'font-icon-block-file-list';
    private static $singular_name = 'Accordion Element';

    private static $plural_name = 'Accordion Element';

    private static $description = 'Displays Accordion of Elements';

    private static $table_name = 'AccordionElement';

	private static $db = [
		'OpenFirst' => 'Boolean(0)',
		'KeepOpenned' => 'Boolean(0)',
	];

    public function getType()
    {
        return self::$singular_name;
    }

    public function Accordion()
    {
        return $this->Elements()->renderWith(static::class.'_AccordionArea');
    }

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldsToTab('Root.Main', [
			CheckboxField::create('OpenFirst', 'Open first accordion element on page load'),
			CheckboxField::create('KeepOpenned', 'Keep elements oppened'),
		]);

		return $fields;
	}
}
