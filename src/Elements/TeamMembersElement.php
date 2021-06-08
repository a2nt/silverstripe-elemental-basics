<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:54 PM
 */

namespace A2nt\ElementalBasics\Elements;
use DNADesign\Elemental\Models\BaseElement;
use A2nt\ElementalBasics\Models\TeamMember;

class TeamMembersElement extends BaseElement
{
    private static $singular_name = 'Team Members';

    private static $plural_name = 'Team Members';

    private static $description = 'Displays random Team Members';

    public function getType()
    {
        return self::$singular_name;
    }

    public function Members()
    {
        return TeamMember::get()->sort('RAND()');
    }
}
