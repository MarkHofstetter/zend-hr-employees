<?php
// application/models/EmployeeMapper.php


class Default_Model_EmployeeMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Default_Model_DbTable_Employee');
        }
        return $this->_dbTable;
    }


    public function save(Default_Model_Employee $employee)
    {
        $data = array(
            'FIRST_NAME'   => $employee->getFirst_name(),
            'LAST_NAME'    => $employee->getLast_name(),
            'SALARY'       => $employee->getSalary(),
        );
		
		print_r($data);

        if (null === ($id = $employee->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
/*
    public function find($id, Default_Model_Guestbook $guestbook)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $guestbook->setId($row->ID)
                  ->setEmail($row->EMAIL)
                  ->setComment($row->COMMENTS)
                  ->setCreated($row->CREATED);
    }
*/
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Employee();
            $entry ->setId($row->EMPLOYEE_ID)
                  ->setFirst_Name($row->FIRST_NAME)
                  ->setLast_Name($row->LAST_NAME)
                  ->setSalary($row->SALARY)
                  ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;
    }
}
