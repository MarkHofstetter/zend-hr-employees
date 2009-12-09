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
        
        $this->addElement('text', 'department_name', array(
            'label'      => 'Department Name:',
            'required'   => true,
            'filters'    => array('StringTrim'), 
            )			
        );			
        
        
        $element = new Zend_Form_Element_Select('foo', array(
          'multiOptions' => array(
          'foo' => 'Foo Option',
          'bar' => 'Bar Option',
          'baz' => 'Baz Option',
          'bat' => 'Bat Option',
            )
         ));
         $element->setValue(array('bar'));
        
        $this->addElement($element);
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
