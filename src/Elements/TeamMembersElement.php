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

/**
 * Class \A2nt\ElementalBasics\Elements\TeamMembersElement
 *
 */
class TeamMembersElement extends BaseElement
{
    private static $table_name = 'A2nt_ElementalBasics_Elements_TeamMembersElement';
    private static $icon = 'font-icon-menu-security';
    private static $singular_name = 'Team Members';

    private static $plural_name = 'Team Members';

    private static $description = 'Displays random Team Members';

    public function getType(): string
    {
        return _t(__CLASS__ . '.BlockType', self::$singular_name);
    }

    public function Members()
    {
        $members = TeamMember::get();
        $this->extend('updateMembers', $members);
        return $members;
    }
}
