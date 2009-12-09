-- Start of DDL Script for Table HR.EMP
-- Generated 09.12.2009 14:41:17 from HR@ORCL

CREATE TABLE emp
    (employee_id,
    first_name,
    last_name,
    salary,
    bonus,
    department_id)
as select employee_id,
    first_name,
    last_name,
    salary,
    bonus,
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

CREATE OR REPLACE TRIGGER check_sum_salary
 BEFORE
  INSERT OR UPDATE
 ON emp
REFERENCING NEW AS NEW OLD AS OLD
declare
  summe number;
  e exception;
  pragma exception_init
    (e, -20001);
  max_summe number;
begin
  max_summe := pck_parameters.get_n('max_emp_salary');
  select sum(salary) into summe from emp;
  if summe > max_summe then
     raise_application_error(-20001, 'Summe zu hoch '||summe||'>'||max_summe );
  end if;
end;
/

CREATE OR REPLACE TRIGGER emp_jn_trg
 BEFORE
  INSERT OR DELETE OR UPDATE
 ON emp
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
declare
  v_type varchar2(2);
begin

v_type := (case when inserting then 'I'
                when updating  then 'U'
                else                'D'
           end);
           
insert into emp_jn (
EMP_JN_ID,
EMPLOYEE_ID,
FIRST_NAME,
LAST_NAME,
SALARY,
SALARY_OLD,
BONUS,
CHANGE_DATE,
CHANGE_TYPE)
values (
hr_seq.nextval,
nvl(:old.employee_id, :new.employee_id),
nvl(:old.FIRST_NAME,  :new.first_name),
nvl(:old.last_NAME,  :new.last_name),
nvl(:new.salary, null),
nvl(:old.salary, null),
nvl(:old.bonus,  :new.bonus),
sysdate,
v_type);

end;
/

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
