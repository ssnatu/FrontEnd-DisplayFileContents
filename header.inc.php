<!DOCTYPE html>
<html>
<head>
	<title>Display File Content</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/style.css" type="text/css" />
</head>
<body>
<div class="container">
  	<div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>Display Content into Seperate Tabs</h2>
    	</div>
    	
    	<div class="panel-body">
    		<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    			<input type="file" name="csv" required />
    			<input type="submit" name="submit" value="Upload">
    		</form>
    		<?php 
    		if (!empty($_SESSION['csvarray']))
			{
				$_SESSION['organization_detials'] = get_organization_details();
				$_SESSION['order_details'] = get_order_details();
				$_SESSION['product_details'] = get_product_details();
			?>
			<div class="tabs">
				<ul class="nav nav-tabs" role="tablist" id="navTabs">
				    <li class="nav-item">
				      <a class="nav-link active" data-toggle="tab" href="#organization">Orgainization Details</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" data-toggle="tab" href="#order">Order Details</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" data-toggle="tab" href="#product">Product Details</a>
				    </li>
			  	</ul>

			  	 <div class="tab-content">
				    <div id="organization" class="container tab-pane fade show active"><br>
				      <?php 
				      	display_organization_detials($_SESSION['organization_detials']); 
				      ?>
				    </div>
				    <div id="order" class="container tab-pane fade"><br>
				      
				      <?php
				      	display_order_details($_SESSION['order_details']); 
				      ?>
				    </div>
				    <div id="product" class="container tab-pane fade"><br>
				      
				      <?php 
				      	display_product_details($_SESSION['product_details']); 
				      ?>
				    </div>
			  	</div>
		  	</div>
			<?php
			}
			else
			{
				$_SESSION = [];
				session_destroy();
			}
			?>
    	</div>    	
  	</div>
</div>

<script type="text/javascript">
  if (location.hash) {
  	$('a[href=\'' + location.hash + '\']').tab('show');
  }

var activeTab = localStorage.getItem('activeTab');

if (activeTab) {
  $('a[href="' + activeTab + '"]').tab('show');
}

$('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
  e.preventDefault()
  var tab_name = this.getAttribute('href')
  if (history.pushState) {
    history.pushState(null, null, tab_name)
  }
  else {
    location.hash = tab_name
  }
  localStorage.setItem('activeTab', tab_name)

  $(this).tab('show');
  return false;
});

$(window).on('popstate', function () {
  var anchor = location.hash ||
    $('a[data-toggle=\'tab\']').first().attr('href');
  $('a[href=\'' + anchor + '\']').tab('show');
});
</script>
</body>
</html>
