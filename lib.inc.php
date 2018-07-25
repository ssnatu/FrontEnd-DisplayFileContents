<?php

/**
 * Read CSV file into array
 *
 * @param $file - File name to be read
 * @return array
 */
function get_csv_data($file)
{
	$csvarray = [];

	if (!empty($file))
	{
		$csv = array_map('str_getcsv', file($file, FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES));
		$key = array_shift($csv); // get keys

		foreach ($csv as $value)
		{
			$csvarray[] = array_combine($key, $value); // make associative array
		}//echo '<pre>'; print_r($csvarray); echo '</pre>';exit;
	}
	return $csvarray;
}


/**
 * Return organization detials
 * 
 * @return array
 */
function get_organization_details()
{
	$organization = [];
	if (!empty($_SESSION['csvarray']))
	{
		foreach ($_SESSION['csvarray'] as $details)
		{
			$organization[] = array_filter($details, function($key) {
		        return (((strpos($key, 'organization') !== FALSE) || $key === 'school_URN') &&
		            strpos($key, 'order') === FALSE);
			}, ARRAY_FILTER_USE_KEY);
		}
	}
	return $organization;
}


/**
 * Return order detials
 * 
 * @return array
 */
function get_order_details()
{
	$order = [];
	if (!empty($_SESSION['csvarray']))
	{
		foreach ($_SESSION['csvarray'] as $details)
		{
			$order[] = array_filter($details, function($key) {
		        return (strpos($key, 'order') !== FALSE);
			}, ARRAY_FILTER_USE_KEY);
		}
	}
	return $order;
}


/**
 * Return product detials
 * 
 * @return array
 */
function get_product_details()
{
	$product = [];
	if (!empty($_SESSION['csvarray']))
	{
		foreach ($_SESSION['csvarray'] as $details)
		{
			$product[] = array_filter($details, function($key) {
		        return (strpos($key, 'product') !== FALSE);
			}, ARRAY_FILTER_USE_KEY);
		}
	}
	return $product;
}


/**
 * Display organization detials
 * 
 * @param array $organization_detials
 * @return null
 */
function display_organization_detials($organization_detials)
{
	if (!empty($organization_detials))
	{
		$_SESSION['organizations'] = paginate($organization_detials);
		$table = '';
		$table .= '<div class="table-responsive">';
		$table .= '<table class="table table-striped table-bordered">';
		$table .= '<thead><tr>';
		$table .= '<th>Org ID</th>';
		$table .= '<th>Org Name</th>';
		$table .= '<th>Org Telephone</th>';
		$table .= '<th>Org Email</th>';
		$table .= '<th>Org URL</th>';
		$table .= '</tr></thead>';
		echo $table;
		$table .= '<tbody>';
		
		foreach ($_SESSION['organizations']['items'] as $organization)
		{
			$row = '';
			$row .= '<tr>';
			$row .= '<td>' . $organization['organization_id'] . '</td>';
			$row .= '<td>' . $organization['organization_name'] . '</td>';
			$row .= '<td>' . $organization['organization_telephone'] . '</td>';
			$row .= '<td>' . $organization['organization_email'] . '</td>';
			$row .= '<td>' . $organization['organization_url'] . '</td></tr>';
			echo $row;
	 	}
	 	
		echo '</tbody></table></div>';
		echo '<div>' . $_SESSION['organizations']['pagination'] . '</div>';
	}
}


/**
 * Display order detials
 * 
 * @param array $order_details
 * @return null
 */
function display_order_details($order_details)
{
	if (!empty($order_details))
	{
		$_SESSION['orders'] = paginate($order_details);
		$table = '';
		$table .= '<div class="table-responsive">';
		$table .= '<table class="table table-striped table-bordered">';
		$table .= '<thead><tr>';
		$table .= '<th>ID</th>';
		$table .= '<th>Date</th>';
		$table .= '<th>Order Name</th>';
		$table .= '<th>Contact Name</th>';
		$table .= '<th>Order Email</th>';
		$table .= '<th>Telephone</th>';
		$table .= '<th>Address</th>';
		$table .= '<th>Total Order</th>';
		$table .= '</tr></thead>';
		echo $table;
		$table .= '<tbody>';
		
		foreach ($_SESSION['orders']['items'] as $order)
		{
			$address = '';
			echo '<tr>';
			echo '<td>' . $order['order_id'] . '</td>';
			echo '<td>' . $order['order_date'] . '</td>';
			echo '<td>' . $order['order_name'] . '</td>';
			echo '<td>' . $order['order_contact_name'] . '</td>';
			echo '<td>' . $order['order_email_address'] . '</td>';
			echo '<td>' . $order['order_telephone'] . '</td>';

			// combine order address
			echo '<td>';
			$address .= $order['order_delivery_address_1'] . ' ' . $order['order_delivery_address_2'];
			$address .= ' ' . $order['order_delivery_address_3'] . ' ' . $order['order_delivery_town']; 
			$address .= ' ' . $order['order_delivery_county'] . ' ' . $order['order_delivery_postcode'];
			$address .= '</td>';
			echo $address;
			echo '<td>' . $order['organization_bulk_order_total'] . '</td>';
			echo '</tr>';
	 	}
		echo '</tbody></table></div>';
		echo '<div>' . $_SESSION['orders']['pagination'] . '</div>';
	}
}


/**
 * Display product detials
 * 
 * @param array $product_details
 * @return null
 */
function display_product_details($product_details)
{
    if (!empty($product_details))
    {
    	$_SESSION['products'] = paginate($product_details);
    	$table = '';
		$table .= '<div class="table-responsive">';
		$table .= '<table class="table table-striped table-bordered">';
		$table .= '<thead><tr>';
		$table .= '<th>Product Name</th>';
		$table .= '<th>Product ColorName</th>';
		$table .= '<th>Color Style Ref</th>';
		$table .= '<th>Product Size Name</th>';
		$table .= '<th>Color Image URL</th>';
		$table .= '<th>Product EAN</th>';
		$table .= '<th>Product Price</th>';
		$table .= '<th>Product Quantity</th>';
		$table .= '<th>Product Line Price</th>';
		$table .= '</tr></thead>';
		echo $table;
		$table .= '<tbody>';

		foreach ($_SESSION['products']['items'] as $product)
		{
			echo '<tr>';
			echo '<td>' . $product['product_name'] . '</td>';
			echo '<td>' . $product['product_colour_name'] . '</td>';
			echo '<td>' . $product['product_colour_style_ref'] . '</td>';
			echo '<td>' . $product['product_size_name'] . '</td>';
			echo '<td>' . $product['product_colour_image_url'] . '</td>';
			echo '<td>' . $product['product_ean'] . '</td>';
			echo '<td>' . $product['product_price'] . '</td>';
			echo '<td>' . $product['product_quantity'] . '</td>';
			echo '<td>' . $product['product_line_price'] . '</td>';
			echo '</tr>';
 		}
 	
		echo '</tbody></table></div>';
		echo '<div>' . $_SESSION['products']['pagination'] . '</div>';
    }
}


/**
 * Paginate array
 * 
 * @param array $details
 * @return array
 */
function paginate(array $details)
{
	$totalrows = count($details);
	$perpage = 10;

	$totalpages = ceil($totalrows / $perpage); // total number of pages

	if ($totalpages < 1)
	{
		$totalpages = 1;
	}

	$page = 1;
	if (isset($_GET['page']))
	{
		$page = (int)$_GET['page'];
	}

	if ($page < 1)
	{ 
		$page = 1; 
	} 
	elseif ($page > $totalpages)
	{ 
		$page = $totalpages; // set page to totalpages page number
	}

	$offset = ($page - 1) * $perpage;

	if ($offset < 0)
	{
		$offset = 0;
	}

	$items = array_slice($details, $offset, $perpage);

	$pagination = "";

	if ($totalpages != 1)
	{
		$pagination .= '<ul class="pagination">';
		// first and previous link
		if ($page > 1) 
		{
			$previous = $page - 1;
			$pagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=1" class="btn btn-default">First</a></li>'; // goto first page
			$pagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $previous . '" class="btn btn-default">Previous</a></li>';
		}

		// display page numbers
		for ($i = 1 ; $i <= $totalpages; $i++)
		{
			if ($i != $page)
			{
				$pagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='. $i .'" class="btn btn-default">'.$i.'</a></li> ';
			}
			else
			{
				$pagination .= '<li class="page-item"><button type="button" class="btn btn-default">' . $i . '</button></li>';
			}
		}

		// last and next link
		if ($page != $totalpages)
		{
	        $next = $page + 1;
	        $pagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='. $next . '" class="btn btn-default">Next</a></li>';
	        $pagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='. $totalpages . '" class="btn btn-default">Last</a></li>'; // goto last page
	    }
	    $pagination .= '</ul>';
	}
	return [
		'items' => $items,
		'pagination' => $pagination,
	];
}