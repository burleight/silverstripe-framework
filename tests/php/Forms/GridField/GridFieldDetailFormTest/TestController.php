<?php

namespace SilverStripe\Forms\Tests\GridField\GridFieldDetailFormTest;

use SilverStripe\Control\Controller;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldViewButton;

class TestController extends Controller implements TestOnly
{
    public function __construct()
    {
        parent::__construct();
        if (Controller::has_curr()) {
            $this->setRequest(Controller::curr()->getRequest());
        }
    }

    public function Link($action = null)
    {
        return Controller::join_links('GridFieldDetailFormTest_Controller', $action, '/');
    }

    private static $allowed_actions = ['Form'];

    protected $template = 'BlankPage';

    public function Form()
    {
        $group = PeopleGroup::get()
            ->filter('Name', 'My Group')
            ->sort('Name')
            ->First();

        $field = new GridField('testfield', 'testfield', $group->People());
        $field->getConfig()->addComponent(new GridFieldToolbarHeader());
        $field->getConfig()->addComponent(new GridFieldAddNewButton('toolbar-header-right'));
        $field->getConfig()->addComponent(new GridFieldViewButton());
        $field->getConfig()->addComponent(new GridFieldEditButton());
        $gridFieldForm = new GridFieldDetailForm($this, 'Form');
        $gridFieldForm->setRedirectMissingRecords(true);
        $field->getConfig()->addComponent($gridFieldForm);
        $field->getConfig()->addComponent(new GridFieldEditButton());
        return new Form($this, 'Form', new FieldList($field), new FieldList());
    }
}
