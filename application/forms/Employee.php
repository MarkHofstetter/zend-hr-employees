<?php
// application/forms/Employee.php

class Default_Form_Employee extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
       
        $this->addElement('text', 'first_name', array(
            'label'      => 'First Name:',
            'required'   => true,
            'filters'    => array('StringTrim')          
            )
        );

        
        $this->addElement('text', 'last_name', array(
            'label'      => 'Last Name:',
            'required'   => true,
            'filters'    => array('StringTrim'),   
			)
        );
        
       $this->addElement('text', 'Salary', array(
            'label'      => 'Salary:',
            'required'   => true,
            'filters'    => array('StringTrim'), 
            )			
        );		
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Add Employee',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}
?>
