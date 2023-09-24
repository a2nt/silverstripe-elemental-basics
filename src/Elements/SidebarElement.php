<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;

use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \A2nt\ElementalBasics\Elements\MapElement
 *
 * @property int $MapZoom
 * @method \SilverStripe\ORM\ManyManyList|\A2nt\ElementalBasics\Models\MapPin[] Locations()
 * @mixin \A2nt\ElementalBasics\Extensions\MapExtension
 */
class SidebarElement extends BaseElement
{
    private static $icon = 'font-icon-book-open';

    private static $singular_name = 'Sidebar Element';

    private static $plural_name = 'Sidebar Elements';

    private static $description = 'Displays sidebar among page elements';

    public function getType(): string
    {
        return self::$singular_name;
    }
}
