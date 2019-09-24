<?php
// MODEL
require_once("connection.php");
class model
{
	private $mainConnection;
	public function getConnection()
	{
		return $this->mainConnection;
	}
	public function setConnection($con)
	{
		$this->mainConnection=$con;
	}
	public function AIOSQL($AIOvars)
	{

// REFINING ARGUEMENTS
		{

			$queryType=$columnsToSelectORInsert=$tables=$conditions=$columnsToSetORCompare=$joinTypes=$groupBy=$having=$orderBy=$limit=0;

			$AIOvars2=array("queryType","columnsToSelectORInsert","tables","conditions","columnsToSetORCompare","joinTypes","groupBy","having","orderBy","limit");
			foreach($AIOvars2 as $key => $value)
				$$value=$AIOvars[$key];
			
			if(!is_array($queryType) && $queryType!==0  && $queryType!=="0")
			{
				$queryType=strtoupper(trim($queryType));
				$queryType=array("$queryType");
			}
			
			$queryType[0]=strtoupper(trim($queryType[0]));

			if(!is_array($conditions[0]) && $conditions!==0 && $conditions!=="0")
			{
				$conditions2=$conditions;
				$conditions=null;
				$conditions=array(array());
				foreach ($conditions2 as $value)
					array_push($conditions[0],$value);
			}
			$queryStr="";
		}

// INSERT/SELECT/UPDATE/DELETE
		{
			$arrQueryTypes=array("INSERT","SELECT","UPDATE","DELETE");
			foreach ($arrQueryTypes as $value)
				if($queryType[0]===$value)
					$queryStr="$value ";
			if($queryStr==="")
				die("Invalid Query Type :(<br>$queryType");
		}
// AFTER INSERT/SELECT/UPDATE/DELETE
		{
			if(($queryType[0]==="INSERT") && $columnsToSelectORInsert!==0 && $columnsToSelectORInsert!=="0")
				$queryStr.="<br>INTO ".$tables." ( ".implode(array_keys($columnsToSelectORInsert)," , ")." )<br>VALUES ( '".implode(array_values($columnsToSelectORInsert),"' , '")."' )";

			elseif($queryType[0]==="SELECT")
			{
				if($columnsToSelectORInsert===0 || $columnsToSelectORInsert==="0")
				{
					if(($tables!==0 && $tables!=="0") && ($joinTypes===0 || $joinTypes==="0"))
						$queryStr.="*<br>FROM ".$tables;
					elseif($joinTypes!==0 && $joinTypes!=="0")
						$queryStr.="*<br>FROM ";
				}
				elseif($columnsToSelectORInsert!==0 && $columnsToSelectORInsert!=="0")
				{
					if($joinTypes===0 || $joinTypes==="0")
						$queryStr.=implode($columnsToSelectORInsert,",")."<br>FROM ".$tables;
					elseif($joinTypes!==0 && $joinTypes!=="0")
						$queryStr.=implode($columnsToSelectORInsert,",")."<br>FROM ";
				}
			}

			elseif($queryType[0]==="UPDATE")
			{
				$queryStr.=$tables."<br>SET ";
				if($columnsToSelectORInsert!==0 && $columnsToSelectORInsert!=="0")
				{
					$cnt=1;
					foreach($columnsToSelectORInsert as $key => $value)
					{
						$queryStr.="$key = '".addslashes(trim($value))."'";
						if($cnt++<count($columnsToSelectORInsert))
							$queryStr.=" , ";
					}
				}
			}

			elseif($queryType[0]==="DELETE")
				$queryStr.="<br>FROM ".$tables;
		}

// JOIN TYPES
		if($joinTypes!==0 && $joinTypes!=="0")
		{
			for($i=0;$i<count($tables)-1;$i++)
				$queryStr.="( ";

			for($i=0;$i<count($tables)-1;$i++)
			{
				if(substr($queryStr,-1)!==")")
					$queryStr.=$tables[$i];

				$joinTypes[$i]=strtoupper(trim($joinTypes[$i]));
				$arrJoinTypes=array("INNER JOIN","LEFT JOIN","RIGHT JOIN","OUTER JOIN");
				foreach ($arrJoinTypes as $value)
					if($joinTypes[$i]==="$value")
						$queryStr.="<br>$value ";

				$queryStr.=$tables[$i+1];
				$queryStr.=" ON ";
				$queryStr.=array_keys($columnsToSetORCompare)[$i]." = ".array_values($columnsToSetORCompare)[$i]." )";
			}
		}

// WHERE/CONDITION/SUB-QUERY
		if($queryType[0]!=="INSERT" && $conditions!==0 && $conditions!=="0")
		{
			$queryStr.="<br>WHERE ";
			$whereCounter=1;
			$subQueryCounter=0;
			$possibleValuesAt1=array("="=>"=","!="=>"!=","<"=>"<","<="=>"<=",">"=>">",">="=>">=","IN"=>"IN","NOTIN"=>"NOT IN","LIKE"=>"LIKE","NOTLIKE"=>"NOT LIKE","BETWEEN"=>"BETWEEN","NOTBETWEEN"=>"NOT BETWEEN","EXISTS"=>"EXISTS","NOTEXISTS"=>"NOT EXISTS","ISNULL"=>"IS NULL","ISNOTNULL"=>"IS NOT NULL");

			foreach($conditions as $key => $value)
			{
				$value[1]=strtoupper(str_replace(' ','',$value[1]));
				$queryStr.=" $value[0] ";
				foreach ($possibleValuesAt1 as $key1 => $value1)
					if($value[1]===$key1)
					{
						$queryStr.=$value1." ";
						break;
					}


				if(count($value)>2)	//					if(isset($value[2]))
				{
					if(is_array($value[2]))
					{
						if($value[1]==="IN" || $value[1]==="NOTIN")
							$queryStr.="( ".implode($value[2]," , ")." ) ";
						elseif($value[1]==="BETWEEN" || $value[1]==="NOTBETWEEN")
							$queryStr.=$value[2][0]." AND ".$value[2][1];
					}
					else
					{
						$original=$value[2];
						$value[2]=strtoupper(trim($value[2]));
						if($value[2]==="SUBQ")
						{
							$queryStr.="( select $value[0] FROM $value[3] WHERE ";
							$subQueryCounter++;
						}
						elseif($value[2]==="AND")
							$queryStr.=" AND ";
						elseif($value[2]==="OR")
							$queryStr.=" OR ";
						elseif($value[2]==="ALL")
							$queryStr.=" ALL ";
						elseif($value[2]==="SOME")
							$queryStr.=" SOME ";
						elseif($value[2]==="ANY")
							$queryStr.=" ANY ";
					elseif($value[2]!=="SUBQ")
							$queryStr.="'".$original."'";
					}
				}


				if(count($value)>3)	//					if(isset($value[3]))
				{
					$original=$value[3];
					$value[3]=strtoupper(trim($value[3]));
					if($value[3]==="SUBQ")
					{	
						$queryStr.="( select $value[0] FROM $value[4] WHERE ";
						$subQueryCounter++;
					}
					elseif($value[3]==="AND")
						$queryStr.=" AND ";
					elseif($value[3]==="OR")
						$queryStr.=" OR ";
					elseif($value[3]==="ALL")
						$queryStr.=" ALL ";
					elseif($value[3]==="SOME")
						$queryStr.=" SOME ";
					elseif($value[3]==="ANY")
						$queryStr.=" ANY ";
					elseif($value[2]!=="SUBQ")
							$queryStr.="'".$original."'";
				}
			}
			for($i=0;$i<$subQueryCounter;$i++)
				$queryStr.=" )";
		}


// GROUP BY
		if($groupBy!==0 && $groupBy!=="0")
		{
			if(!is_array($groupBy) && $groupBy!==0  && $groupBy!=="0")
			{
				$groupBy=trim($groupBy);
				$groupBy=array("$groupBy");
			}
			$queryStr.="<br>GROUP BY ".implode($groupBy,' , ');
			if($having!==0 && $having!=="0")
			{
				$queryStr.="<br>HAVING ";
				if(!is_array($having[0]))
				{
					$having2=$having;
					$having=null;
					$having=array(array());
					foreach ($having2 as $value)
						array_push($having[0],$value);					
				}
				foreach ($having as $key => $value)
				{
					$value[0]=strtoupper(trim($value[0]));
					if($value[0]==="COUNT" || $value[0]==="MIN" || $value[0]==="MAX" || $value[0]==="SUM" || $value[0]==="AVG")
						$queryStr.=$value[0]." ( ".$value[1];

					$value[2]=strtoupper(str_replace(' ','',$value[2]));

					if($value[2]==="=" || $value[2]==="!=" || $value[2]==="<" || $value[2]==="<=" || $value[2]===">" || $value[2]===">=")
						$queryStr.=" ) ".$value[2]." ".$value[3]." ";
					elseif($value[2]==="IN")
						$queryStr.=" ) IN ( ".implode($value[3]," , ")." ) ";
					elseif($value[2]==="NOTIN")
						$queryStr.=" ) NOT IN ( ".implode($value[3]," , ")." ) ";
					elseif($value[2]==="BETWEEN")
						$queryStr.=" ) BETWEEN ".$value[3][0]." AND ".$value[3][1];
					elseif($value[2]==="NOTBETWEEN")
						$queryStr.=" ) NOT BETWEEN ".$value[3][0]." AND ".$value[3][1];

					$len=count($value);
					if($len>3)
					{
						$len--;
						$value[$len]=strtoupper(trim($value[$len]));
						if($value[$len]==="OR")
							$queryStr.=" OR ";
						elseif($value[$len]==="AND")
							$queryStr.=" AND ";
					}
				}
			}
		}

// ORDER BY
		if($orderBy!==0 && $orderBy!=="0")
		{
			if(!is_array($orderBy[0]))
			{
				$orderBy2=$orderBy;
				$orderBy=null;
				$orderBy=array(array());
				foreach ($orderBy2 as $value)
					array_push($orderBy[0],$value);					
			}
			foreach ($orderBy as $key => $value)
			{
				if($key>0)
					$queryStr.=" , $value[0] ";
				else
					$queryStr.="<br>ORDER BY  $value[0] ";
				$value[1]=strtoupper(trim($value[1]));
				if($value[1]==="ASC")
					$queryStr.=" ASC ";
				elseif($value[1]=="DESC")
					$queryStr.=" DESC ";
			}
		}

// LIMIT
		if($limit!==0 && $limit!=="0")
		{
			if(!is_array($limit))
				$limit=array("$limit");
			$queryStr.="<br>LIMIT ".$limit[0];
			if(count($limit)===2)
				$queryStr.=" OFFSET ".$limit[1];
		}

// RETURN RESULT
		die($queryStr);
		if(count($queryType)===1)
		{
			//die($queryStr);
			$queryStr=str_replace("<br>"," ",$queryStr);
			$res=$this->getConnection()->query($queryStr) or die(mysqli_error($this->getConnection()));
			if($res==null)
				return 0;
			else
				if($res->num_rows<1)
					return 1;
				else
				{
					while($dd=$res->fetch_object())
						$objArr[]=$dd;
					return $objArr;
				}
		}
		elseif( count($queryType)===2 && ($queryType[1]===2 || $queryType[1]==="2" || $queryType[1]=="return" || $queryType[1]=="RETURN" ) )
			return str_replace("<br>"," ",$queryStr);
	}
}
?>