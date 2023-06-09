<?php

	include 'auth/database.php';

	$message = "";

	if(!empty($_POST))
	{
		$output = "";
		$tableName = mysqli_real_escape_string($connect, $_POST['tableName']);
		$capacity = mysqli_real_escape_string($connect, $_POST['capacity']);
		$availability = $_POST['availability'];
		$status = $_POST['status'];

		$query = "INSERT INTO book_table(table_name, capacity, availability, status) VALUES('$tableName', '$capacity', '$availability', '$status')";
		$message = "Data Inserted Successfully!!!";

		if(mysqli_query($connect, $query))
		{
			//$output .= "<p class='bg-success text-white w-100 pt-2 pb-2 pl-3 pr-3 mb-3' style='border-radius: 5px;'>Store Added Successfully...</p>";
			$output .= "
				<div class='alert alert-success alert-dismissible fade show w-100' role='alert'>
					<strong>" . $message . "</strong>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    	<span aria-hidden='true'>&times;</span>
				  	</button>
				</div>
			";
			$select_query = "SELECT * FROM book_table ORDER BY id DESC";
			$result = mysqli_query($connect, $select_query);
			$output .= "
				<table class='table table-hover w-100' id='table'>
					<thead class='thead-dark'>
				    	<tr>
				      		<th scope='col'>Id</th>
				      		<th scope='col'>Table Name</th>
				      		<th scope='col'>Capacity</th>
				      		<th scope='col'>Available</th>
				      		<th scope='col'>Status</th>
				      		<th scope='col'>Action</th>
				    	</tr>
				  	</thead>
			";


			while($data = mysqli_fetch_array($result))
			{	
				if($data['status'] == 'active' && $data['availability'] == 'available')
				{
		    		$output .= "
				    	<tbody
					    	<tr>
					      		<td> " . $data['id'] . "</td>
					      		<td> " . $data['table_name'] . "</td>
					      		<td> " . $data['capacity'] . "</td>
					      		<td><span class='available'>" . $data['availability'] . "</span></td>
					      		<td><span class='active-status'>" . $data['status'] . "</span></td>
					      		<td>
					      			<div class='row'>
					      				<button type='submit' name='edit' id='" . $data['id'] . "' class='btn btn-sm btn-primary mr-2 edit_data'>Edit</button>
					      				<a href='delete_table.php?id=" . $data['id'] . "' name='cancel' class='btn btn-sm btn-danger delete_data'>Delete</a>
					      			</div>
					      		</td>
					    	</tr>
					    </tbody>
	    			";
	    		}
	    		else if($data['status'] == 'active' && $data['availability'] == 'unavailable')
	    		{
	    			$output .= "
				    	<tbody
					    	<tr>
					      		<td> " . $data['id'] . "</td>
					      		<td> " . $data['table_name'] . "</td>
					      		<td> " . $data['capacity'] . "</td>
					      		<td><span class='unavailable'>" . $data['availability'] . "</span></td>
					      		<td><span class='active-status'>" . $data['status'] . "</span></td>
					      		<td>
					      			<div class='row'>
					      				<button type='submit' name='edit' id='" . $data['id'] . "' class='btn btn-sm btn-primary mr-2 edit_data'>Edit</button>
					      				<a href='delete_table.php?id=" . $data['id'] . "' name='cancel' class='btn btn-sm btn-danger delete_data'>Delete</a>
					      			</div>
					      		</td>
					    	</tr>
					    </tbody>
	    			";
	    		}
	    		else if($data['status'] == 'inactive' && $data['availability'] == 'available')
	    		{
	    			$output .= "
				    	<tbody
					    	<tr>
					      		<td> " . $data['id'] . "</td>
					      		<td> " . $data['table_name'] . "</td>
					      		<td> " . $data['capacity'] . "</td>
					      		<td><span class='available'>" . $data['availability'] . "</span></td>
					      		<td><span class='inactive-status'>" . $data['status'] . "</span></td>
					      		<td>
					      			<div class='row'>
					      				<button type='submit' name='edit' id='" . $data['id'] . "' class='btn btn-sm btn-primary mr-2 edit_data'>Edit</button>
					      				<a href='delete_table.php?id=" . $data['id'] . "' name='cancel' class='btn btn-sm btn-danger delete_data'>Delete</a>
					      			</div>
					      		</td>
					    	</tr>
					    </tbody>
	    			";
	    		}	
	    		else
	    		{
	    			$output .= "
				    	<tbody
					    	<tr>
					      		<td> " . $data['id'] . "</td>
					      		<td> " . $data['table_name'] . "</td>
					      		<td> " . $data['capacity'] . "</td>
					      		<td><span class='unavailable'>" . $data['availability'] . "</span></td>
					      		<td><span class='inactive-status'>" . $data['status'] . "</span></td>
					      		<td>
					      			<div class='row'>
					      				<button type='submit' name='edit' id='" . $data['id'] . "' class='btn btn-sm btn-primary mr-2 edit_data'>Edit</button>
					      				<a href='delete_table.php?id=" . $data['id'] . "' name='cancel' class='btn btn-sm btn-danger delete_data'>Delete</a>
					      			</div>
					      		</td>
					    	</tr>
					    </tbody>
	    			";
	    		}	
		    }

		    $output .= "</table>";
		}

		echo $output;

	}	

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.active-status, .available{
		  background-color: #28a745 !important;
		  font-size: 14px;
		  color: white;
		  padding: 1.5px 5px;
		  border-radius: 2px;
		}

		.inactive-status, .unavailable{
		  background-color: #dc3545 !important;
		  font-size: 14px;
		  color: white;
		  padding: 1.5px 5px;
		  border-radius: 2px;
		}

		.unavailable{ background-color: #ffc107 !important; }
	</style>
</head>
<body>
	<script type="text/javascript">
		function SearchField() {
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET", "table_search.php?search="+document.getElementById('search').value, false);
			xmlhttp.send(null);

			document.getElementById('display').innerHTML=xmlhttp.responseText;
      	}
	</script>
</body>
</html>
