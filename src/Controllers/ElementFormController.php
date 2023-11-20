<?php

namespace A2nt\ElementalBasics\Controllers;

use DNADesign\Elemental\Models\BaseElement;
use DNADesign\ElementalUserForms\Control\ElementFormController as ControlElementFormController;
use SilverStripe\Control\Director;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\ValidationResult;

class ElementFormController extends ControlElementFormController
{
    private static $allowed_actions = [
        'finished',
    ];

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
