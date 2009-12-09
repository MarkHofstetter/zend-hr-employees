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

    private function getDepartmentIdByName($department_name) {
      $db = Zend_Registry::Get('db');
      $sql = sprintf("select department_id from 
                       departments where department_name = :department_name");
                       
      # $stmt = new Zend_Db_Statement_Oracle($db, $sql);
      # array(':department_name' => $department_name)
      $stmt = $db->query($sql, array(':department_name' => $department_name));
      $stmt->execute();
      $id = $stmt->fetchColumn(0);
      return $id;
    }

    public function save(Default_Model_Employee $employee)
    {
        $data = array(
            'FIRST_NAME'   => $employee->getFirst_name(),
            'LAST_NAME'    => $employee->getLast_name(),
            'SALARY'       => $employee->getSalary(),
            'DEPARTMENT_ID' =>  $this->getDepartmentIdByName($employee->getDepartment_name()),
        );
		
		print_r($data);

        if (null === ($id = $employee->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
       # $db = Zend_Registry::Get('db');
       # $db->commit();
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
        $entries   = array();
        $db = Zend_Registry::Get('db');
        $sql = sprintf("select first_name, last_name, salary, department_name from 
                       emp e, departments d where e.department_id = d.department_id(+) order by employee_id desc");
        $stmt = $db->query($sql);
        $stmt->execute();
        while($row = $stmt->fetch()) {
          $e = new Default_Model_Employee();
          $e->setFirst_Name($row['FIRST_NAME']);
          $e->setLast_Name($row['LAST_NAME']);
          $e->setSalary($row['SALARY']);
          $e->setDepartment_Name($row['DEPARTMENT_NAME']);
          $entries[] = $e;
        }
        /*
        $row = $stmt->fetch()
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Employee();
            $entry ->setId($row->EMPLOYEE_ID)
                  ->setFirst_Name($row->FIRST_NAME)
                  ->setLast_Name($row->LAST_NAME)
                  ->setSalary($row->SALARY)
                  ->setMapper($this);
            $entries[] = $entry;
        }*/
        
        
        return $entries;
    }
}
