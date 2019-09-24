<?php

//controller
	require_once("model.php");

	$modelObj=new model;
	$ConnectionObj=new connection;
/*	$connection=$ConnectionObj->connectToDB("flipziadb");
	$modelObj->setConnection($connection);*/
	$modelObj->setConnection($ConnectionObj->connectToDB("flipziadb"));

	$queryType=$columnsToSelectORInsert=$tables=$conditions=$columnsToSetORCompare=$joinTypes=$groupBy=$having=$orderBy=$limit=0;

// INSERT
/*	$queryType="1";
	$columnsToSelectORInsert=array("empid"=>"1","empname"=>"ramesh","empcity"=>"surendranagar");
	$tables="temp";
	$conditions="0";
	$columnsToSetORCompare="0";
	$joinTypes="0";
	$groupBy=0;*/


// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=0;
	$columnsToSetORCompare=0;
	$joinTypes=0;*/



// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=array(array("empid","IN",array("1","2","3","4")));
	$columnsToSetORCompare=0;
	$joinTypes=0;
	$groupBy=0;*/



// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=array(array("empid","IN",array("1","2","3","4"),"AND"),array("empcity","=","value2"));
	$columnsToSetORCompare=0;
	$joinTypes=0;*/




// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=array("empcity","isnotnull");
	$columnsToSetORCompare=0;
	$joinTypes=0;*/




// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=array(array("empcity","isnotnull","AND"),array("empcity","=","value2"));
	$columnsToSetORCompare=0;
	$joinTypes=0;*/




// SELECT *
/*	$queryType=2;
	$columnsToSelectORInsert="ProductID";
	$tables="tblproduct";
	$conditions=array(array("empid","BETWEEN",array("1","10")));
	$columnsToSetORCompare=0;
	$joinTypes=0;
	$groupBy=0;*/






// SELECT columnName
/*	$queryType=" select ";
	$columnsToSelectORInsert=array("empid","empname");
	$tables="temp";*/




// SELECT columnName FROM table WHERE conditions 
/*	$queryType="2";
	$columnsToSelectORInsert=array("empid","empname");
	$tables="temp";
	$conditions=array(array("empid","=","1","AND"),array("empid",">","2","OR"),array("empcity","!=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/



// SELECT columnName FROM table WHERE conditions 
/*	$queryType=array("2","2");
	$columnsToSelectORInsert=array("userid","username");
	$tables="temp";
	$conditions=array(array("userid","=","1","AND"),array("userid","<","2","OR"),array("usercity","!=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/

	//$tables=$modelObj->AIOSQL($queryType,$columnsToSelectORInsert,$tables,$conditions,$columnsToSetORCompare,$joinTypes);
	//$tables="($tables) AS T1";



/*	die("hello:$tables");*/

// SELECT columnName FROM table1 INNERJOIN table2 ON... WHERE conditions 
/*	$queryType="  select  ";
	$columnsToSelectORInsert=array("pd.ProductID","clrxpd.ColorXProductID","clr.ColorName");
//	$columnsToSelectORInsert=0;
	$tables=array("tblproduct AS pd","tblcolorxproduct AS clrxpd","tblcolor AS clr");
	$conditions=array(array("clr.ColorName","=","Black","AND"),array("clr.ColorName","=","white"));
	$columnsToSetORCompare=array("pd.ProductID"=>"clrxpd.ProductID","clrxpd.ColorID"=>"clr.ColorID");
	$joinTypes=array("1","2");*/



// SELECT columnName FROM table1 INNERJOIN table2 ON... WHERE SUBQUERY
/*	$queryType="  select  ";
	$columnsToSelectORInsert=array("pd.ProductID","clrxpd.ColorXProductID","clr.ColorName");
//	$columnsToSelectORInsert=0;
	$tables=array("tblproduct AS pd","tblcolorxproduct AS clrxpd","tblcolor AS clr");
	$conditions=array(array("empid",">","ANY","subq","tblemp"),array("empcityid","IN","subq","tblcities"),array("city","=","surat"));
//	$conditions=array(array("empid",">","ANY","subq","tblemp"),array("empcityid","IN",array(1,2,3,4,5,6)));
	$columnsToSetORCompare=array("pd.ProductID"=>"clrxpd.ProductID","clrxpd.ColorID"=>"clr.ColorID");
	$joinTypes=array(1,2);
	$groupBy=0;
	$having=0;
	$orderBy=0;
	$limit=0;*/


// SELECT columnName FROM table1 INNERJOIN table2 ON... WHERE CONDITIONS + SUBQUERY
	$queryType="  select  ";
	$columnsToSelectORInsert=array("pd.ProductID","clrxpd.ColorXProductID","clr.ColorName");
//	$columnsToSelectORInsert=0;
	$tables=array("tblproduct AS pd","tblcolorxproduct AS clrxpd","tblcolor AS clr");
//	$conditions=array(array("empid","11","1"),array("empcityid",">","ALL","tblcities"),array("city","surat",""));
	$conditions=array(array("empid","   not   between ",array(1,10)),array("empid","=","11","AND"),array("empcityid",">","ALL","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare=array("pd.ProductID"=>"clrxpd.ProductID","clrxpd.ColorID"=>"clr.ColorID");
	$joinTypes=array("  inner join   ","  left join");
	$groupBy=array("abc","pqr");
//	$groupBy="pqr";
//	$having=array("count","empid",">","10");
	$having=array(array("count","empid",">","5","OR"),array("min","empid","IN",array("1","2","3"),"AND"),array("count","empid","BETWEEN",array("1","10"),"or"),array("count","empid",">","5"));
//	$orderBy=array("empid","asc");
	$orderBy=array(array("empid","asc"),array("empname","desc"));
	$limit=array(1,5);



// SELECT columnName FROM table1 INNERJOIN table2 ON... WHERE CONDITIONS + SUBQUERY
/*	$queryType=array("  select  ");
	$columnsToSelectORInsert=array("pd.ProductID","clrxpd.ColorXProductID","clr.ColorName");
//	$columnsToSelectORInsert=0;
	$tables=array("tblproduct AS pd","tblcolorxproduct AS clrxpd","tblcolor AS clr");
//	$conditions=array(array("empid","11","1"),array("empcityid",">","ALL","tblcities"),array("city","surat",""));
	$conditions=array(array("empid","LIKE","va_ue1","AND"),array("empcity","=","value2"));
	$columnsToSetORCompare=array("pd.ProductID"=>"clrxpd.ProductID","clrxpd.ColorID"=>"clr.ColorID");
	$joinTypes=array("1","2");*/




// UPDATE table set pqr=xyz... WHERE conditions 
/*	$queryType="3";
	$columnsToSelectORInsert=array("empname"=>"ramesh","empcity"=>"surendranagar");
	$tables="temp";
	$conditions=array(array("empid","=","1","OR"),array("empid","=","2","AND"),array("empcity","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/




// UPDATE table set pqr=xyz... WHERE conditions 
/*	$queryType="3";
	$columnsToSelectORInsert=array("empname"=>"ramesh","empcity"=>"surendranagar");
	$tables="temp";
	$conditions=array(array("empid","EXISTS","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/






// UPDATE table set pqr=xyz... WHERE SUBQUERY 
/*	$queryType="3";
	$columnsToSelectORInsert=array("empname"=>"ramesh","empcity"=>"surendranagar");
	$tables="temp";
	$conditions=array(array("empid","ANY","subq","tblemp"),array("empcityid","IN","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/

// UPDATE table set pqr=xyz... WHERE SUBQUERY 
/*	$queryType="3";
	$columnsToSelectORInsert=array("empname"=>"ramesh","empcity"=>"surendranagar");
	$tables="temp";
	$conditions=array(array("empid","=","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/







// UPDATE table set pqr=xyz... WHERE conditions 
/*	$queryType="update";
	$columnsToSelectORInsert=array("a"=>"b");
	$tables="1";
	$conditions=array("p","=","q");
	$columnsToSetORCompare=0;
	$joinTypes=0;*/



// DELETE FROM table WHERE conditions
/*	$queryType=array("delete",2);
	$columnsToSelectORInsert="0";
	$tables="temp";
	$conditions=array(array("empid","=","1","OR"),array("empid","=","2","AND"),array("empcity","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/




// DELETE FROM table WHERE conditions
/*	$queryType=array("delete",2);
	$columnsToSelectORInsert="0";
	$tables="temp";
	$conditions=array(array("empid","=","value1","AND"),array("empid","=","value2"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/



// DELETE FROM table WHERE conditions
/*	$queryType=array("delete",2);
	$columnsToSelectORInsert="0";
	$tables="temp";
	$conditions=array(array("empid","=","value1","OR"),array("empid",">=","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/



// DELETE FROM table WHERE conditions
/*	$queryType=array("delete",2);
	$columnsToSelectORInsert="0";
	$tables="temp";
	$conditions=array("empid","LIKE","emp1%");
	$columnsToSetORCompare="0";
	$joinTypes="0";
*/




// DELETE FROM table WHERE conditions
/*	$queryType=array("delete",2);
	$columnsToSelectORInsert="0";
	$tables="temp";
	$conditions=array(array("empid",">","ALL","subq","tblcities"),array("city","=","surat"));
	$columnsToSetORCompare="0";
	$joinTypes="0";*/







/*	$userData=$modelObj->AIOSQL($connection,$queryType,$columnsToSelectORInsert,$tables,$joinTypes,$columnsToSetORCompare,$conditions);*/

/*	$userData=$modelObj->AIOSQL($connection,$queryType,$columnsToSetORCompare,$tables,$conditions);*/

	$AIOvars=array();

	$AIOvars2=array("queryType","columnsToSelectORInsert","tables","conditions","columnsToSetORCompare","joinTypes","groupBy","having","orderBy","limit");
	foreach($AIOvars2 as $key => $value)
		array_push($AIOvars,$$value);

	$userData=$modelObj->AIOSQL($AIOvars);


/*	$userData=$modelObj->AIOSQL($queryType,$columnsToSelectORInsert,$tables,$conditions,$columnsToSetORCompare,$joinTypes,$groupBy,$having,$orderBy,$limit);*/



/*	echo $modelObj->AIOSQL($queryType,$columnsToSelectORInsert,$tables,$conditions,$columnsToSetORCompare,$joinTypes);*/

	//print_r($userData);

	foreach ($userData as $dd)
	{
		echo $dd->ProductName."<br>";
	}

?>