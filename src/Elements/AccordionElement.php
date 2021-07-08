<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;

use DNADesign\ElementalList\Model\ElementList;

class AccordionElement extends ElementList
{
    private static $icon = 'font-icon-block-file-list';
    private static $singular_name = 'Accordion Element';

    private static $plural_name = 'Accordion Element';

    private static $description = 'Displays Accordion of Elements';

    private static $table_name = 'AccordionElement';

    public function getType()
    {
        return self::$singular_name;
    }

    public function Accordion()
    {
        return $this->Elements()->renderWith(static::class.'_AccordionArea');
    }
}
