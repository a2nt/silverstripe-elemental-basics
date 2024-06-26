<?php

namespace A2nt\ElementalBasics\Models;

use A2nt\SilverStripeMapboxField\MapboxField;
use A2nt\SilverStripeMapboxField\MarkerExtension;
use gorriecoe\LinkField\LinkField;
use gorriecoe\Link\Models\Link;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use A2nt\ElementalBasics\Elements\MapElement;
use Symbiote\Addressable\Addressable;

/**
 * Class \A2nt\ElementalBasics\Models\MapPin
 *
 * @property int $Version
 * @property boolean $DirectionsByAddress
 * @property boolean $LatLngOverride
 * @property float $Lat
 * @property float $Lng
 * @property string $Address
 * @property string $Suburb
 * @property string $State
 * @property string $Postcode
 * @property string $Country
 * @property string $Title
 * @property boolean $ShowAtMap
 * @property int $PhoneNumberID
 * @property int $FaxID
 * @method \Sheadawson\Linkable\Models\Link PhoneNumber()
 * @method \Sheadawson\Linkable\Models\Link Fax()
 * @method \SilverStripe\ORM\ManyManyList|\A2nt\ElementalBasics\Elements\MapElement[] MapElements()
 * @mixin \Symbiote\Addressable\Addressable
 * @mixin \A2nt\SilverStripeMapboxField\MarkerExtension
 * @mixin \SilverStripe\Versioned\Versioned
 */
class MapPin extends DataObject
{
    private static $table_name = 'MapPin';

    private static $db = [
        'Title' => 'Varchar(255)',
        'ShowAtMap' => 'Boolean(1)',
    ];

    private static $has_one = [
        'PhoneNumber' => Link::class,
        'Fax' => Link::class,
    ];

    private static $extensions = [
        Addressable::class,
        MarkerExtension::class,
        Versioned::class,
    ];

    private static $belongs_many_many = [
        'MapElements' => MapElement::class,
    ];

    private static $default_sort = 'Title ASC, ID DESC';

    private static $summary_fields = [
        'Title',
        'Address',
        'ShowAtMap',
    ];

    private static $defaults = [
        'ShowAtMap' => '1',
        'Suburb' => 'Syracuse',
        'State' => 'NY',
        'Postcode' => '13210',
        'Country' => 'US',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('MapElements');

        $fields->replaceField(
            'PhoneNumberID',
            LinkField::create('PhoneNumber', 'Phone Number', $this, [
                'types' => ['Phone']
            ])
        );

        $fields->replaceField(
            'Fax',
            LinkField::create('Fax', 'FAX', $this, [
                'types' => ['Phone']
            ])
        );
        $fields->removeByName(['Map', 'LatLngOverride', 'Lng','Lat']);

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('ShowAtMap', 'Show at the map?'),
            CheckboxField::create('LatLngOverride', 'Override Latitude and Longitude?')
                ->setDescription('Check this box and save to be able to edit the latitude and longitude manually.'),
            MapboxField::create('Map', 'Choose a location', 'Lat', 'Lng'),
        ]);

        $this->extend('updateMapPinFields', $fields);

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $lng = $this->getField('Lng');
        $lat = $this->getField('Lat');


        if (!$this->getField('Country')) {
            $this->setField('Country', 'us');
        }

        // geocode
        try {
            // reverse geocoding get address
            if (!$this->hasAddress() && $lng && $lat) {
                require_once BASE_PATH . '/app/thirdparty/geocoding-example/php/Mapbox.php';
                $mapbox = new \Mapbox(MapboxField::getAccessToken());

                // GET Address
                $res = $mapbox->reverseGeocode($lng, $lat);
                if ($res->success() && $res->getCount()) {
                    $res = $res->getData();
                    if (count($res) && isset($res[0]['place_name'])) {
                        $details = explode(',', $res[0]['place_name']);
                        $fields = [
                            'Address',
                            'City',
                            'State',
                            //'Country',
                        ];

                        $n = count($fields);
                        for ($i = 0; $i < $n; $i++) {
                            if (!isset($details[$i])) {
                                continue;
                            }

                            $name = $fields[$i];
                            $val = $details[$i];

                            // get postal code
                            if ($name === 'State') {
                                $this->setField('PostalCode', substr($val, strrpos($val, ' ')+1));
                            }

                            $this->setField($name, $val);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }
}
