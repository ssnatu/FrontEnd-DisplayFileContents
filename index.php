<?php

require_once 'lib.inc.php';

	session_start();

	if (!isset($_GET['page']))
	{
		$_SESSION = [];
	}
	
	// first check file_uploads is on
	if (!ini_get('file_uploads'))
	{
    	ini_set('file_uploads', '1');
	}

	$csvarray = [];

	if (isset($_POST["submit"]))
	{
		// check file is set and there are no errors
   		if (isset($_FILES["csv"]))
   		{	
		    if ($_FILES['csv']['error'] > 0)
		    {
			    echo "File upload error: " . $_FILES["csv"]["error"] . "<br />";
			}
			else
			{
			    $name = $_FILES['csv']['name']; // name of the file
			    $tmp = explode('.', $_FILES['csv']['name']); // find extensions of the file
			    $ext = strtolower(end($tmp));

			    $tmp_name = $_FILES['csv']['tmp_name'];

			    if ($ext === 'csv')
			    {
			        $_SESSION['csvarray'] = get_csv_data($tmp_name); // read CSV data

			    }
		    }
		}
		else
	    {
	        echo "No file selected <br>";
	    }
	}

include_once 'header.inc.php';

?>

