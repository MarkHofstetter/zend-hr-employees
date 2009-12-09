-- Start of DDL Script for Table HR.EMP
-- Generated 09.12.2009 14:41:17 from HR@ORCL

CREATE TABLE emp
as select employee_id,
    first_name,
    last_name,
    salary,
    department_id
    from employees;




-- Indexes for EMP

CREATE INDEX last_name_ind ON emp
  (
    last_name                       ASC
  )
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
/



-- Constraints for EMP

ALTER TABLE emp
ADD CONSTRAINT pk_emp PRIMARY KEY (employee_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
/



-- Triggers for EMP


CREATE OR REPLACE TRIGGER insert_trg
 BEFORE
  INSERT
 ON emp
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
begin
  :new.employee_id := hr_seq.nextval;
end;
/


-- End of DDL Script for Table HR.EMP

-- Foreign Key
ALTER TABLE emp
ADD CONSTRAINT emp_dep_fk FOREIGN KEY (department_id)
REFERENCES departments (department_id)
/
-- End of DDL script for Foreign Key(s)
