<?php

namespace A2nt\ElementalBasics\Controllers;

use DNADesign\ElementalUserForms\Control\ElementFormController as ControlElementFormController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\ORM\ValidationResult;

class ElementFormController extends ControlElementFormController
{
    private static $allowed_actions = [
        'Form',
        'finished',
    ];

    public function Form()
    {
        $form = parent::Form();

        // Elements actions
        $current = Controller::curr();
        $link = $current->Link();

        if (is_a($current, self::class)) {
            $link = $current->getElement()->getPage()->Link();
        }

        $link = Director::makeRelative($link);
        $link = !$link || $link === '/' ? '/home' : $link;

        $form->setFormAction(
            Controller::join_links(
                '/',
                $link,
                'element',
                $this->owner->ID,
                __FUNCTION__
            )
        );

        return $form;
    }

    public function finished()
    {
        $user = $this->getUserFormController();
        $user->finished();

        $page = $this->getPage();
        if (Director::is_ajax()) {
            $el = $this->getElement();
            return json_encode([
                'message' => $el->OnCompleteMessage,
                'status' => ValidationResult::TYPE_GOOD,
            ]);
        }

        return parent::finished();
    }
}
