<?php

class HrController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $employee = new Default_Model_Employee();
        $this->view->entries = $employee->fetchAll();

    }
	
	public function blaAction()
    {
        
        $this->view;

    }

    public function addemployeeAction()
    {
        $request = $this->getRequest();
        $form    = new Default_Form_Employee();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $model = new Default_Model_Employee($form->getValues());
                $model->save();
                return $this->_helper->redirector('index');
            }
        }
        
        $this->view->form = $form;
    }	


}

