<?php

namespace A2nt\ElementalBasics\Tasks;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;

class RemoveOldElementsTask extends BuildTask
{
    protected $title = 'Remove Old Elements';
    protected $description = 'Removes old Elements from DB if there\'s no such class';

    public function run($request)
    {
        $els = ClassInfo::subclassesFor(BaseElement::class);
        $badEls = BaseElement::get()->filter('ClassName:not', array_values($els));

        echo '<h1>BAD:</h1>';
        foreach ($badEls as $bad) {
            echo 'Found <b>#'.$bad->ID.'</b> '.$bad->ClassName .'<br/>';
            //$bad->delete();
        }

        echo 'Done!';
    }
}
