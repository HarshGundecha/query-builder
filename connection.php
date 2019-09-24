<?php
//connection
	class connection
	{
		function connectToDB($db)
		{
			return new mysqli("localhost","root","",$db);			
		}
	}
?>