<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/30/18
 * Time: 11:36 PM
 */

namespace A2nt\ElementalBasics\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use A2nt\CMSNiceties\Extensions\SocialExtension;

/**
 * Class \A2nt\ElementalBasics\Models\TeamMember
 *
 * @property int $Version
 * @property string $FirstName
 * @property string $LastName
 * @property string $Company
 * @property string $Position
 * @property string $Content
 * @property int $FacebookID
 * @property int $LinkedInID
 * @property int $PinterestID
 * @property int $InstagramID
 * @property int $TwitterID
 * @property int $YouTubeID
 * @property int $PublicEmailID
 * @property int $PhoneNumberID
 * @property int $PhotoID
 * @method \Sheadawson\Linkable\Models\Link Facebook()
 * @method \Sheadawson\Linkable\Models\Link LinkedIn()
 * @method \Sheadawson\Linkable\Models\Link Pinterest()
 * @method \Sheadawson\Linkable\Models\Link Instagram()
 * @method \Sheadawson\Linkable\Models\Link Twitter()
 * @method \Sheadawson\Linkable\Models\Link YouTube()
 * @method \Sheadawson\Linkable\Models\Link PublicEmail()
 * @method \Sheadawson\Linkable\Models\Link PhoneNumber()
 * @method \SilverStripe\Assets\Image Photo()
 * @mixin \A2nt\CMSNiceties\Extensions\SocialExtension
 * @mixin \SilverStripe\Versioned\Versioned
 */
class TeamMember extends DataObject
{
    private static $table_name = 'TeamMember';

    private static $db = [
        'FirstName' => 'Varchar(254)',
        'LastName' => 'Varchar(254)',
        'Company' => 'Varchar(254)',
        'Position' => 'Varchar(254)',
        'Content' => 'HTMLText',
    ];

    private static $has_one = [
        'Photo' => Image::class,
    ];

    private static $extensions = [
        SocialExtension::class,
        Versioned::class,
    ];

    private static $owns = [
        'Photo',
    ];

    private static $summary_fields = [
        'Company',
        'FirstName',
        'LastName',
        'Position',
    ];

    private static $searchable_fields = [
        'FirstName',
        'LastName',
    ];

    private static $frontend_searchable_fields = [
        'FirstName:PartialMatch',
        'LastName:PartialMatch',
        'Content:PartialMatch',
    ];

    public function getTitle()
    {
        return $this->getField('Company').' | '.$this->getField('FirstName').' '.$this->getField('LastName');
    }

    public function getPage()
    {
        $el = \A2nt\ElementalBasics\Elements\TeamMembersElement::get()->first();
        return $el ? $el->getPage() : false;
    }
}
