<?php
-3-
col	-	=/!=/</<=/>/>=	-	value	-	["AND/OR"]
col	-	=/!=/</<=/>/>=	-	["tbl"]
col	-	=/!=/</<=/>/>=	-	[op(in/any/all/some)]	-	["tbl"]
col	-	[op(in/any/all/some)]	-	["tbl"]
col	-	value	-	op(and/or)

-4-
col	-	=/!=/</<=/>/>=	-	op(in/any/all/some)		-	tbl



$string = str_replace(' ','',$string);



$having=array(array("count","empid",">","5","OR"),array("min","empid","IN",array("1","2","3"),"AND"),array("count","empid","BETWEEN",array("1","10"),"or"),array("count","empid",">","5"));


=, !=, >, >=, <, <=, IN, NOTIN, BETWEEN, NOT BETWEEN
AND,OR




[0][0] - column

1 - 
- =/!=/</<=/>/>=
- IN /NOTIN / NOT IN
- LIKE /NOTLIKE / NOT LIKE
- BETWEEN / NOTBETWEEN /NOT BETWEEN
- EXISTS/NOTEXISTS / NOT EXISTS
- ISNULL / IS NULL / ISNOTNULL / IS NOT NULL / 


- =/!=/</<=/>/>= / 
- IN /NOTIN / 
- LIKE /NOTLIKE / 
- BETWEEN / NOTBETWEEN / 
- EXISTS/NOTEXISTS / 
- ISNULL / ISNOTNULL  



2-
- array() of values for IN or BETWEEN
- AND / OR / ALL / ANY /SOME
- subq
- value
- Error/Warning/Notice("doesnt exist")

3-
- Error/Warning/Notice("doesnt exist")
- value
- AND / OR 
- subq






where empid =/ 'value'								array(array("empid","=","value"))

where empid =/ 'value' and/ empid=value				array(array("empid","=","value1","AND/"),array("empid","=","value2"))

where empid =/ (sq)									array(array("empid","=","subq","tblcities"),array("city","=","surat"))

where empid = 'value1' and/ empid>=(sq)				array(array("empid","=","value1","OR"),array("empid",">=","subq","tblcities"),array("city","=","surat"))

where empid like/ 'value'							array(array("empid","LIKE","value"))

where empid like/ 'value1' and empcity='value2'		array(array("empid","LIKE","value1","AND"),array("empcity","=","value2"))

where empid in/ 'values'							array(array("empid","IN",array("1","2","3","4")))

where empid in/ 'values' and empcity='value2'		array(array("empid","IN",array("1","2","3","4"),"AND"),array("empcity","=","value2"))

where empid IS NOT NULL/							array(array("empcity","isnotnull"))

where empid IS NOT NULL/ and empcity='value2'		array(array("empcity","isnotnull","AND"),array("empcity","=","value2"))

where empid between/ ("lowerBound","upperBound")	array(array("empid","BETWEEN/",array("1","10")))

where empid EXISTS/ (sq)							array(array("empid","EXISTS/","subq"),array("tblcities","city","=","surat"))

where empid >all/ (sq)								array(array("empid",">","ALL","subq"),array("tblcities","city","=","surat"))



is null/is not null -   SELECT * FROM CUSTOMERS WHERE AGE IS NOT NULL;	array("age","ISNULL/IS NULL/isnull/is null") or array("age","ISNOTNULL/IS NOT NULL/isnotnull/is not null")

like - SELECT * FROM CUSTOMERS WHERE NAME LIKE 'Ko%';					array("name","LIKE/like","Ko%")

not like - SELECT * FROM CUSTOMERS WHERE NAME LIKE 'Ko%';				array("name","NOTLIKE/NOT LIKE/notlike/not like","Ko%")

in - SELECT * FROM CUSTOMERS WHERE AGE IN ( 25, 27, 55 );				array("age","IN/in",array("25","27","55"))

not in - SELECT * FROM CUSTOMERS WHERE AGE IN ( 25, 27, 55 );			array("age","NOTIN/NOT IN/notin/not in",array("25","27","55"))

between - SELECT * FROM CUSTOMERS WHERE AGE BETWEEN 25 AND 27;			array("age","BETWEEN/between",array("25","27"))

not between - SELECT * FROM CUSTOMERS WHERE AGE BETWEEN 25 AND 27;		array("age","NOTBETWEEN/NOT BETWEEN/notbetween/not between",array("25","27"))

$queryStr.="<br>WHERE ";
if(conditions[1]!='EXISTS')
	$queryStr.=$value[0];
elseif(conditions[1]=='EXISTS')
	$queryStr.=$value[1]

exists - SELECT AGE FROM CUSTOMERS WHERE EXISTS (SELECT AGE FROM CUSTOMERS WHERE SALARY > 6500);
	array(array("age","EXISTS","customers"),array("salary",">","6500"))





and - SELECT * FROM CUSTOMERS WHERE AGE >= 25 AND SALARY >= 6500;	array(array("age",">=","25","AND"),array("salary",">=","6500"))

or - SELECT * FROM CUSTOMERS WHERE AGE >= 25 OR SALARY >= 6500;		array(array("age",">=","25","OR"),array("salary",">=","6500"))

> all - SELECT * FROM CUSTOMERS 
WHERE AGE > ALL (SELECT AGE FROM CUSTOMERS WHERE SALARY > 6500);	array(array("age",">","ALL","CUSTOMERS"),array("salary",">","6500"))

> any - SELECT * FROM CUSTOMERS 
WHERE AGE > ANY (SELECT AGE FROM CUSTOMERS WHERE SALARY > 6500);	array(array("age",">","ANY","CUSTOMERS"),array("salary",">","6500"))

?>