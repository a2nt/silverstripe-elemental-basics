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
use LeKoala\CmsActions\CmsInlineFormAction;
use LeKoala\CmsActions\HasPrevNextUtils;
use SilverStripe\Control\Controller;
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

    public function onAfterUpdateCMSActions(FieldList $fields)
    {
        self::addPrevNextUtils($this->owner, $fields);
    }

    public function PrevRecord()
    {
        $obj = $this->owner;
        $parent = $obj->Parent();
        if (!$parent) {
            return;
        }

        $els = $parent->Elements();
        if (!$els) {
            return;
        }

        return $els->filter('Sort:LessThan', $obj->Sort)->first();
    }

    public function NextRecord()
    {
        $obj = $this->owner;
        $parent = $obj->Parent();
        if (!$parent) {
            return;
        }

        $els = $parent->Elements();
        if (!$els) {
            return;
        }

        return $els->filter('Sort:GreaterThan', $obj->Sort)->first();
    }

    /**
     * @param FieldList $utils
     * @return FieldList
     */
    public static function addPrevNextUtils($obj, FieldList $utils)
    {
        $controller = Controller::curr();
        $request = $controller->getRequest();
        $url = rtrim($request->getURL(), '/') . '/';

        $query = $_GET;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $routeParams = $request->routeParams();
        $recordClass = get_class($obj);

        $getPreviousRecordID = $routeParams['cmsactions'][$recordClass]['PreviousRecordID'] ?? $request->param('PreviousRecordID');
        $getNextRecordID = $routeParams['cmsactions'][$recordClass]['NextRecordID'] ?? $request->param('NextRecordID');

        $search = sprintf('/%d/', $obj->ID);
        $replaceStr = '/%d/';
        $PrevRecordLink = $routeParams['cmsactions'][$recordClass]['PrevRecordLink'] ?? null;
        $NextRecordLink = $routeParams['cmsactions'][$recordClass]['NextRecordLink'] ?? null;
        if (!$PrevRecordLink) {
            $PrevRecordLink = str_replace($search, sprintf($replaceStr, $getPreviousRecordID), $url);
        }
        if (!$NextRecordLink) {
            $NextRecordLink = str_replace($search, sprintf($replaceStr, $getNextRecordID), $url);
        }

        if ($obj->ID && $getNextRecordID) {
            $utils->unshift(
                $NextBtnLink = new CmsInlineFormAction(
                    'NextBtnLink',
                    _t('HasPrevNextUtils.Next', 'Next') . ' >',
                    'btn-secondary'
                )
            );
            $NextBtnLink->setLink($NextRecordLink);
        }
        if ($obj->ID && $getPreviousRecordID) {
            $utils->unshift(
                $PrevBtnLink = new CmsInlineFormAction(
                    'PrevBtnLink',
                    '< ' . _t('HasPrevNextUtils.Previous', 'Previous'),
                    'btn-secondary'
                )
            );
            $PrevBtnLink->setLink($PrevRecordLink);
        }

        return $utils;
    }
}
