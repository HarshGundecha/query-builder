<?php
	require_once("connection.php");
	class model
	{
		public function selectinnerjoin($tbl,$columnsToSelect,$columnsToCompare,$con)
		{
			$sel="SELECT"

			if($columnsToSelect==0)
				$sel=$sel." * ";
			else
				$sel=$sel.implode($columnsToSelect,",");

			$sel=$sel." FROM ";

			for($i=0;$i<$tbl.count;i++)
				$sel=$sel."(";

			for($i=0;$i<$tbl.count;i++)
			{
				$sel=$sel.$tbl[$i];
				$sel=$sel." INNER JOIN ";
				$sel=$sel.$tbl[$i+1];
				$sel=$sel." ON ";
				$sel=$sel.$tbl[$i].".".$columnsToSelect[$i]."=".$tbl[$i+1].".".$columnsToSelect[$i].")";
			}
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