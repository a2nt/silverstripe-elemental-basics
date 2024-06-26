<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 6/23/18
 * Time: 1:23 PM
 */

namespace A2nt\ElementalBasics\Extensions;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;

/**
 * Class \A2nt\ElementalBasics\Extensions\BaseElementEx
 *
 * @property \A2nt\ElementalBasics\Extensions\BaseElementEx $owner
 */
class BaseElementEx extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $obj = $this->owner;
        parent::updateCMSFields($fields);

        if ($obj->ID) {
            $fields->insertBefore(
                'Title',
                LiteralField::create(
                    'AnchorName',
                    '<div class="field"><div class="form__field-holder">'
                    .'Element Anchor name: <b>#e'.$obj->ID.'</b>'
                    .'</div></div>'
                )
            );
        }

        $tab = $fields->findOrMakeTab('Root.Settings');

        $tab->push(LiteralField::create(
            'Type',
            '<div class="form-group field text">'
            .'<div class="form__field-label">Type</div>'
            .'<div class="form__field-holder">'.(!Director::isLive() ? $obj->getField('ClassName') : $obj->i18n_singular_name()).'</div>'
            .'</div>'
        ));

        if ($obj->ID) {
            $tab->push(TreeDropdownField::create(
                'MoveElementIDToPage',
                'Move an element to page',
                SiteTree::class
            )->setEmptyString('(select an element to move)'));
        }
    }

    public static function MoveElementToPage($ID, $moveToID)
    {
        $el = BaseElement::get()->byID($ID);
        $page = SiteTree::get()->byID($moveToID);
        if (!$page || !$el) {
            return false;
        }

        $el->setField('ParentID', $page->ElementalArea()->ID);
        $el->write();

        return true;
    }

    public function updateCMSEditLink(&$link): void
    {
        if (!method_exists($this->owner, 'inlineEditable')) {
            return;
        }

        if (!$this->owner->inlineEditable()) {
            $page = $this->owner->getPage();

            if (!$page || $page instanceof SiteTree) {
                return;
            }

            // As non-page DataObject's are managed via GridFields, we have to grab their CMS edit URL
            // and replace the trailing /edit/ with a link to the nested ElementalArea edit form
            $relationName = $this->owner->getAreaRelationName();
            $link = preg_replace(
                '/edit\/?$/',
                "ItemEditForm/field/{$relationName}/item/{$this->owner->ID}/edit/",
                $page->CMSEditLink()
            );
        }
    }


    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $el = $this->owner;

        // clone page title to first element title
        $class = DataObject::getSchema()->hasOneComponent($el, 'Parent');
        $area = ($el->ParentID) ? DataObject::get_by_id($class, $el->ParentID) : null;
        if ($area instanceof ElementalArea && $area->exists()) {
            if ($area->Elements()->count() === 0 && !$el->getField('Title') && $el->hasMethod('getPage')) {
                $page = $el->getPage();
                if ($page) {
                    $el->setField('Title', $page->getField('Title'));
                    $el->setField('ShowTitle', true);
                }
            }
        }



        $moveID = $el->getField('MoveElementIDToPage');
        if ($el->ID && $moveID) {
            self::MoveElementToPage($el->ID, $moveID);
        }
    }
}
