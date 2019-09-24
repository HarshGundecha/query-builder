<?php
//model
	require_once("connection.php");
	class model
	{
		public function insert($tbl,$data,$con)
		{
			$k=array_keys($data);
			$kk=implode($k,",");

			$v=array_values($data);
			$vv=implode($v,"','");

			$ins="insert into $tbl ($kk) values ('$vv')";
			$res=$con->query($ins) or die($ins);
			return $res;
		}

		public function display($tbl,$data,$con)
		{
			$sel="select * from $tbl";
			if($data!=0)
			{
				$sel.=" where ";
				$cnt=1;
				foreach ($data as $key => $value)
				{
					$sel.="$key='$value'";
					if($cnt<count($data))
					{
						$sel.=" and ";
						$cnt++;
					}
				}
			}
			//echo $sel;
			$res=$con->query($sel);
			if($res==null)
			{
				return 0;
			}
			else
			{
				if($res->num_rows<1)
				{
					return 1;
				}
				else
				{
					while($dd=$res->fetch_object())
					{
						$arr[]=$dd;
					}
					return $arr;
				}
			}
		}

		public function update($tbl,$data1,$condition1,$con)
		{
			$sel="update $tbl set ";
			if($data1!=0)
			{
				$cnt=1;
				foreach ($data1 as $key => $value)
				{
					$sel.="$key='$value'";
					if($cnt<count($data1))
					{
						$sel.=",";
						$cnt++;
					}
				}
			}

			if($condition1!=0)
			{
				$sel.=" where ";
				$cnt=1;
				foreach ($condition1 as $key => $value)
				{
					$sel.="$key='$value'";
					if($cnt<count($condition1))
					{
						$sel.=" and ";
						$cnt++;
					}
				}
			}

			$res=$con->query($sel);

			echo $sel;

			if($res==null)
			{
				return 0;
			}
			else
			{
				if($res->num_rows<1)
				{
					return 1;
				}
				else
				{
					while($dd=$res->fetch_object())
					{
						$arr[]=$dd;
					}
					return $arr;
				}
			}
		}

		public function delete($tbl,$data,$con)
		{
			$sel="delete from $tbl";
			if($data!=0)
			{
				$sel.=" where ";
				$cnt=1;
				foreach ($data as $key => $value)
				{
					$sel.="$key='$value'";
					if($cnt<count($data))
					{
						$sel.=" and ";
						$cnt++;
					}
				}
			}
			//echo $sel;
			$res=$con->query($sel);
			if($res==null)
			{
				return 0;
			}
			else
			{
				if($res->num_rows<1)
				{
					return 1;
				}
				else
				{
					while($dd=$res->fetch_object())
					{
						$arr[]=$dd;
					}
					return $arr;
				}
			}
		}

		public function selectinnerjoin($tbl,$columnsToSelect,$joinType,$columnsToCompare,$condition,$con)
		{
			$sel="SELECT ";

			if($columnsToSelect==0)
				$sel.=" * ";
			else
				$sel.=implode($columnsToSelect,",");

			$sel.=" FROM ";

			for($i=0;$i<count($tbl)-1;$i++)
				$sel.="(";

			$k=array_keys($columnsToCompare);

			$v=array_values($columnsToCompare);

			for($i=0;$i<count($tbl)-1;$i++)
			{
				if(substr($sel,-1)!=")")
					$sel.=$tbl[$i];

				switch(strtoupper($joinType[$i]))
				{
					case "1":
					case "INNER JOIN":					
						$sel.=" INNER JOIN ";
					break;

					case "2":
					case "LEFT JOIN":
						$sel.=" LEFT JOIN ";
					break;

					case "3":
					case "RIGHT JOIN":
						$sel.=" RIGHT JOIN ";
					break;

					case "4":
					case "OUTER JOIN":
						$sel.=" OUTER JOIN ";
					break;
				}

				$sel.=$tbl[$i+1];
				$sel.=" ON ";
				$sel.=$k[$i]."=".$v[$i].")";
			}
			if($condition!=0)
			{
				$sel.=" where ";
				$cnt=1;
				foreach ($condition as $key => $value)
				{
					//$sel.="$key='$value'";
					$sel.="$value[0]='$value[1]'";
					if($cnt<count($condition))
					{
						if($value[2]=="1")
							$sel.=" and ";
						elseif($value[2]=="2")
							$sel.=" or ";
						$cnt++;
					}
				}
			}
			die($sel);
			$res=$con->query($sel);
			if($res==null)
				return 0;
			else
				if($res->num_rows<1)
					return 1;
				else
				{
					while($dd=$res->fetch_object())
						$arr[]=$dd;
					return $arr;
				}
		}

	}
?>