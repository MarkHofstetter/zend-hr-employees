<?php

// application/models/Employee.php

/*
EMPLOYEE_ID                     NOT NULL  NUMBER(6,0)
FIRST_NAME                                VARCHAR2(20)
LAST_NAME                                 VARCHAR2(25)
SALARY                                    NUMBER(8,2)
BONUS                                     NUMBER
DEPARTMENT_ID                             NUMBER
*/

class Default_Model_Employee
{
    protected $_first_name;
    protected $_last_name;
    protected $_salary;
    protected $_department_name;
    protected $_id;
    protected $_mapper;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Employee property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Employee property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setFirst_name($text)
    {
        $this->_first_name = (string) $text;
        return $this;
    }

    public function getFirst_name()
    {
        return $this->_first_name;
    }

    public function setLast_name($text)
    {
        $this->_last_name = (string) $text;
        return $this;
    }

    public function getLast_name()
    {
        return $this->_last_name;
    }

    public function setSalary($number)
    {
        $this->_salary = $number;
        return $this;
    }

    public function getSalary()
    {
        return $this->_salary;
    }
    
    public function setDepartment_Name($text)
    {
        $this->_department_name = $text;
        return $this;
    }

    public function getDepartment_Name()
    {
        return $this->_department_name;
    }

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Default_Model_EmployeeMapper());
        }
        return $this->_mapper;
    }

    public function save()
    {
        $this->getMapper()->save($this);
    }

    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }

    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}
