//connection
<?php
	class connection
	{
		function connectoToDB()
		{
			$con=new mysqli("localhost","root","root","db");
			return $con;
		}
	}
	
?>

//model
<?php 
	require_once("connection.php");

	class model
	{
		public function insert($tbl,$data,$con)
		{
			$k=array_keys($data);
			$kk=impload($k,",");

			$v=array_values($data);
			$vv=impload($v," ',' ");

			$ins="insert into $tbl ($kk) values ('$vv')";
			$res=$con->query($ins) or die($ins);
			return $res;
		}
	}
?>

//controller
<?
	require_once("model.php");

	$modelObj=new model;
	$ConnectionObj=new connection;
	$mainConnection=$ConnectionObj->connect();

	if(isset($_REQUEST["btnSubmit"]))
	{
		$data["username"]=$_REQUEST["txtusername"];
		$data["password"]=$_REQUEST["txtpassword"];
		$modelObj->insert("tbluser",$data,$mainConnection);
		header("location:abc");
	}
?>

//view
<?php require_once("controller.php") ?>
<html>
	<body>
		<form>	
			username <input type="text" name="txtusername" /><br>
			password <input type="text" name="txtpassword" /><br>
			<input type="submit" name="btnSubmit" value="Submit">
		</form>
	</body>
</html>