<?php
//session_start();
require( '../../../wp-load.php' );
$sessionid = $_COOKIE['PHPSESSID'];
$catid = $_POST['recurring_order_category'];
	if($_POST['recurring_order_category'] == 1 || $_POST['recurring_order_category'] == 2){
		$_SESSION["dog"]['category_id'] = $_POST['recurring_order_category'];
	}
	else{
		$_SESSION["cat"]['category_id'] = $_POST['recurring_order_category'];
	}
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
		$introcost = $_SESSION['intro_cost'];
	}else{
		$introcost = "14.95";
	}
	$_SESSION["recurring_order"] = $_POST['recurring_order'];
	$recurring_order_category = $_POST['recurring_order_category'];
	if($_POST['recurring_order']){
		$pro_price = $_POST['recurring_order'] - $_SESSION["shipment_price"];
		$query = mysql_query("UPDATE wp_carts_final SET price = '$pro_price',category_id = '$catid'
		WHERE session_id = '".$sessionid."' and pet_type = '0'");
	}

	//$qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	//$result = $wpdb->get_results($qry, ARRAY_A);
	// print_r($result);
	//print_r($_POST);die;
	$_SESSION["categ"] = $_POST['recurring_order_category'];
	header('Location:http:/step-3a/');die;
?>
