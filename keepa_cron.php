<?php
require('includes/config.php');
require('includes/function.php');
require('includes/mainClass.php');
require('classes/function_PDO.php');

function cleantext($string) {
   $string = str_replace("'", "&#39;", $string); // Replaces all spaces with hyphens.
   return $string; // Removes special chars.
}


function getData($month,$main_string,$asin=null){
    $lastthreemonthdate = date("y-m-d", strtotime("-" . $month . " Months"));
    $timelast           = strtotime($lastthreemonthdate);
    $keepatime          = 21564000;
    $userkey = "2eb2uemiuov371rdkl7pjpk5gor1a853ejtsrcb200j1l1bvr6ljh972g2lrl412";
	$title    = cleantext($main_string['products'][0]->title);
	$asinno   = $main_string['products'][0]->asin;
	//$category = $main_string['products'][0]->categories;
	$category = $main_string['products'][0]->rootCategory;
	$height   = $main_string['products'][0]->packageHeight;
	$width    = $main_string['products'][0]->packageWidth;
	$length   = $main_string['products'][0]->packageLength;
	$product_data = $main_string['products'][0]->csv;
	$weight       = $main_string['products'][0]->packageWeight;
	global $dbh;
	echo "<h2>Product Name: $title</h2>";
	echo "<h2>Asin No: $asinno</h2>";
	$data           = array();
	$datamarket     = array();
	$datamarketused = array();
	$datasalesdata  = array();

if (!empty($product_data[0])) {
    foreach ($product_data[0] as $productkey => $productval) {
        if ($productkey % 2 == 0) {
            $data['data']['date'][] = $productval;
            
        } else {
            $data['data']['price'][] = $productval;
        }
        
        
        
}
$amazon_price = end($data['data']['price']);
$amazon_price = $amazon_price/100;
    echo '<h2>Amazon Price history</h2>';
    $count = 0;
    foreach ($data['data']['date'] as $key => $val) {
        
        $keepamin = ($val + $keepatime) * 60;
        if ($keepamin > $timelast) {
            //echo $keepamin;
            $dt = new DateTime("@$keepamin");
            
            $fprice                           = $data['data']['price'][$key] / 100;
            $results_array['data']['price'][] = $fprice;
	    
            $results_array['data']['date'][]  = $dt->format('Y-m-d:H:i:s');
            if ($fprice == "-0.01") {
                $fprice = "Out of Stock";
                
            } else {
                $count++;
                
            }
            
            $totalprice += $fprice;
            
            
        }
      
        
        
    }
    
   
    if ($count > 0) {
        $avg       = $totalprice / $count;
        $lowprice  = $avg / 3;
        $highprice = $avg * 3;
	$avg = number_format($avg, 2, '.', '');
        echo "<h3>Avg Price: $avg</h3>";
    } else {
        
        echo "<h4>No history found in last ".$month." Months</h4>";
    }
    if (!empty($results_array)) {
        foreach ($results_array['data']['date'] as $key => $val) {
            
            $resultprice = $results_array['data']['price'][$key];
            $resultdate  = $results_array['data']['date'][$key];
            
            if ($resultprice == "-0.01") {
                $resultprice = "Out of Stock";
                
            }
            if ($resultprice >= $lowprice && $resultprice <= $highprice) {
                
                echo 'Date=' . $resultdate . ' and Price=' . $resultprice . "<br>";
                $minmaximum[] = $resultprice;
                
            }
            
            
            
        }
        
       
        $minimum = @min($minmaximum);
        $maximum = @max($minmaximum);
        echo "<h4>Minimum Price: $minimum</h4>";
        echo "<h4>Maximum Price: $maximum</h4>";
        
        
    }
}
 

if (!empty($product_data[1])) {
    
    foreach ($product_data[1] as $productkey => $productval) {
        if ($productkey % 2 == 0) {
            $datamarket['data']['date'][] = $productval;
            
        } else {
            $datamarket['data']['price'][] = $productval;
        }

    }
    echo '<h2>Marketplace New price history</h2>';
    $counter      = 0;
    $result_array = array();
    foreach ($datamarket['data']['date'] as $key => $val) {
        
        $keepamin = ($val + $keepatime) * 60;
        if ($keepamin > $timelast) {
            //echo $keepamin;
            $dt = new DateTime("@$keepamin");
            
            $fprice                          = $datamarket['data']['price'][$key] / 100;
            $result_array['data']['price'][] = $fprice;
            $result_array['data']['date'][]  = $dt->format('Y-m-d:H:i:s');
            
            if ($fprice == "-0.01") {
                $fprice = "Out of Stock";
                
            } else {
                $counter++;
                
            }
            $totalmarketprice += $fprice;
           
            
        }

        
    }
    if ($counter > 0) {
        $avgfirst      = $totalmarketprice / $counter;
        $lowest_price  = $avgfirst / 3;
        $highest_price = $avgfirst * 3;
	$avgfirst = number_format($avgfirst, 2, '.', '');
        echo "<h3>Avg Price: $avgfirst</h3>";
    }
    
    else {
        
        echo "<h4>No history found in last ".$month." Months</h4>";
    }
    if (!empty($result_array)) {
        foreach ($result_array['data']['date'] as $key => $val) {
            
            $finalprice = $result_array['data']['price'][$key];
            $finaldate  = $result_array['data']['date'][$key];
            
            if ($finalprice == "-0.01") {
                $finalprice = "Out of Stock";
                
            }
            if ($finalprice >= $lowest_price && $finalprice <= $highest_price) {
                
                echo 'Date=' . $finaldate . ' and Price=' . $finalprice . "<br>";
                $minmax[] = $finalprice;
                
            }
            
            
            
        }
        
        $min = min($minmax);
        $max = max($minmax);
        echo "<h4>Minimum Price: $min</h4>";
        echo "<h4>Maximum Price: $max</h4>";
    }
}

 

if (!empty($product_data[2])) {
    
    foreach ($product_data[2] as $productkey => $productval) {
        if ($productkey % 2 == 0) {
            $datamarketused['data']['date'][] = $productval;
            
        } else {
            $datamarketused['data']['price'][] = $productval;
        }
        
        
        
    }
    echo '<h2>Marketplace Used price history</h2>';
    $counts = 0;
    foreach ($datamarketused['data']['date'] as $key => $val) {
        
        $keepamin = ($val + $keepatime) * 60;
        if ($keepamin > $timelast) {
            $dt = new DateTime("@$keepamin");
            
            $fmarketprice                          = $datamarketused['data']['price'][$key] / 100;
            $market_price['data']['price'][] = $fmarketprice;
            $market_price['data']['date'][]  = $dt->format('Y-m-d:H:i:s');
            if ($fmarketprice == "-0.01") {
                $fmarketprice = "Out of Stock";
                
            } else {
                $counts++;
                
            }
            $totalpriceused += $fmarketprice;
           
            
        }
        
    }
    if ($counts > 0) {
	
        $avgsecond = $totalpriceused / $counts;
	$avgsecond = number_format($avgsecond, 2, '.', '');
	$lowest_used_price  = $avgsecond / 3;
        $highest_used_price = $avgsecond * 3;
        echo "<h3>Avg Price: $avgsecond</h3>";
    } else {
        echo "<h4>No history found in last ".$month." Months</h4>";
        
    }
    if (!empty($market_price)) {
        foreach ($market_price['data']['date'] as $key => $val) {
            
            $finalmarketprice = $market_price['data']['price'][$key];
            $finalmarketdate  = $market_price['data']['date'][$key];
            
            if ($finalmarketprice == "-0.01") {
                $finalmarketprice = "Out of Stock";
                
            }
            if ($finalmarketprice >= $lowest_used_price && $finalmarketprice <= $highest_used_price) {
                
                echo 'Date=' . $finalmarketdate . ' and Price=' . $finalmarketprice . "<br>";
                $marketminmax[] = $finalmarketprice;
                
            }
            
            
            
        }
        
        $mini = min($marketminmax);
        $maxi = max($marketminmax);
        echo "<h4>Minimum Price: $mini</h4>";
        echo "<h4>Maximum Price: $maxi</h4>";
        
    }
}
 
if (!empty($product_data[3])) {
    
    foreach ($product_data[3] as $productkey => $productval) {
        if ($productkey % 2 == 0) {
            $datasalesdata['data']['date'][] = $productval;
            
        } else {
            $datasalesdata['data']['price'][] = $productval;
        }
        
    }
    echo '<h2>Sales price history</h2>';
    $countsales = 0;
    
    $sales_rank = end($datasalesdata['data']['price']);
    foreach ($datasalesdata['data']['date'] as $key => $val) {
        
        $keepamin = ($val + $keepatime) * 60;
        if ($keepamin > $timelast) {
            //echo $keepamin;
            $dt = new DateTime("@$keepamin");
            
            $fprice = $datasalesdata['data']['price'][$key];
            if ($fprice == "-0.01") {
                $fprice = "Out of Stock";
                
            } else {
                $countsales++;
                
            }
            $totalsalesprice += $fprice;
            echo 'Date='.$dt->format('Y-m-d:H:i:s').' and Rank='.$fprice."<br>";
            
        }
        
        
        
    }
    if ($countsales > 0) {
        $avgthird = $totalsalesprice / $countsales;
	$avgthird = number_format($avgthird, 2, '.', '');
        echo "<h3>Avg Sales Rank: $avgthird</h3>";
    } else {
        
        echo "<h4>No history found in last ".$month." Months</h4>";
    }
    
}


 
if (!empty($product_data[11])) {
    
    foreach ($product_data[11] as $productkey => $productval) {
        if ($productkey % 2 == 0) {
            $offersdata['data']['date'][] = $productval;
            
        } else {
            $offersdata['data']['price'][] = $productval;
        }
        
        
        
        
        
        
    }
    echo '<h2>No of Offer history</h2>';
    $countoffers = 0;

    foreach ($offersdata['data']['date'] as $key => $val) {
        
        $keepamin = ($val + $keepatime) * 60;
        if ($keepamin > $timelast) {
            //echo $keepamin;
            $dt = new DateTime("@$keepamin");
            
            $offer = $offersdata['data']['price'][$key];
	     $offer_price['data']['price'][] = $offer ;
            $offer_price['data']['date'][]  = $dt->format('Y-m-d:H:i:s');
            if ($offer == "-1") {
                $offer = "Out of Stock";
                
            } else {
                $countoffers++;
                
            }
            $totaloffercount += $offer;
          
        }
        
        
        
    }
    if ($countoffers > 0) {
	   $avgfourth = $totaloffercount / $countoffers;
	$lowoffer = $avgfourth/3;
	$highoffer = $avgfourth*3;
     $avgfourth = number_format($avgfourth, 2, '.', '');
        echo "<h3>Avg offer Rank: $avgfourth</h3>";
    } else {
        
        echo "<h4>No Offer history found in last ".$month." Months</h4>";
    }
    
        if (!empty($offer_price)) {
        foreach ($offer_price['data']['date'] as $key => $val) {
            
            $finalofferprice = $offer_price['data']['price'][$key];
            $finalofferdate  = $offer_price['data']['date'][$key];
            
            if ($finalofferprice == "-1") {
                $finalofferprice = "Out of Stock";
                
            }
            if ($finalofferprice >= $lowoffer && $finalofferprice <= $highoffer) {
                
                echo 'Date=' . $finalofferdate . ' and Price=' . $finalofferprice . "<br>";
                $offerminmax[] = $finalofferprice;
                
            }
            
            
            
        }
        
        $offermini = min($offerminmax);
        $offermaxi = max($offerminmax);
        echo "<h4>Minimum Offer: $offermini</h4>";
        echo "<h4>Maximum Offer: $offermaxi</h4>";
        
    }
    
}

$keepacat = $category;
if(!empty($keepacat)){
  $categurl = "https://api.keepa.com/category/?key=$userkey&domain=1&category=$keepacat&parents=1"; 
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $categurl);
curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true );
 
curl_setopt($ch1, CURLOPT_ENCODING, "gzip,deflate");     
$categresponse = curl_exec($ch1);
curl_close($ch1);

$categjson = $categresponse;

$decode = (array) json_decode($categjson);
 
foreach ($decode['categories'] as $key => $value) {
    if ($value->parent == '0') {
      $categoryname = $value->name;
    }
    
}
}




$lastdate = date('Y-m-d H:i:s');
$lastmodified = date('Y-m-d H:i:s');

 $result = "INSERT INTO `items_keepa_data`(`asin`, `item_name`, `item_category`,`rank`,`amazon_price`,`amazon_avg_price`,`amazon_minimum_price`,`amazon_maximum_price`,`avg_price_duration`,`marketplace_avg_price`,`marketplace_minimum_price`,`marketplace_maximum_price`,`marketplace_used_avg_price`,`marketplace_used_minimum_price`,`marketplace_used_maximum_price`,`salesrank_avg`,`offer_avg`,`minimum_offer`,`maximum_offer`,`item_weight`,`item_height`,`item_width`,`item_length`,`last_checked_date`) VALUES ('$asinno','$title','test','$sales_rank','$amazon_price','$avg','$minimum','$maximum','$month','$avgfirst','$min','$max','$avgsecond','$mini','$maxi','$avgthird','$avgfourth','$offermini','$offermaxi','$weight','$height','$width','$length','$lastdate')";
 
  if($title == ''){
	$result = "INSERT INTO `items_keepa_data`(`asin`, `item_name`, `item_category`,`amazon_price`,`amazon_avg_price`,`amazon_minimum_price`,`amazon_maximum_price`,`avg_price_duration`,`marketplace_avg_price`,`marketplace_minimum_price`,`marketplace_maximum_price`,`marketplace_used_avg_price`,`marketplace_used_minimum_price`,`marketplace_used_maximum_price`,`salesrank_avg`,`offer_avg`,`minimum_offer`,`maximum_offer`,`item_weight`,`item_height`,`item_width`,`item_length`,`last_checked_date`) VALUES ('$asin','Not found','test','','','','','$month','','','','','0','0','0','0','0','0','0','0','0','0','$lastdate')";
}

$q = $dbh->prepare($result);
$q->execute();
     echo "Data Saved Successfully";
$res = fetch_query("select * from `items` where asin ='$asinno'");
$cat = $res['category'];
$itemrank = $res['category'];
if (!empty($categoryname)) {
   $q1 = $dbh->prepare("Update `items_keepa_data` SET `item_category`='$categoryname' where asin ='$asinno'");
   $q1->execute();
   $q2 =$dbh->prepare("Update `items` SET `category`='$categoryname',`height`='$height',`width`=$width,`depth`=$length,`weight`='$weight' where asin ='$asinno'");
$q2->execute();
} else {
     $q3 =$dbh->prepare("Update `items_keepa_data` SET `item_category`='$cat' where asin ='$asinno'");
     $q3->execute();
}

$q4 =$dbh->prepare("Update `items` SET `rank`='$sales_rank' where asin ='$asinno'");
$q4->execute();





/* Save and update data into DB End */

}

global $dbh;
$query = "select asin from items where asin NOT IN (select distinct(asin) from items_keepa_data) AND asin_status != 'pending' AND asin_status != 'error' AND asin_status != 'invalid' AND asin_status != 'forcecheck' Limit 25";
$result="";
$cron = 1;
$results = fetch_all_query($query);
if(!empty($results)){
if($cron == 1){
foreach($results as $result) {
$userkey = "2eb2uemiuov371rdkl7pjpk5gor1a853ejtsrcb200j1l1bvr6ljh972g2lrl412";
$asin = $result['asin'];
$response="";
$url = "https://api.keepa.com/product/?key=$userkey&domain=1&type=product&asin=$asin";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
$response = curl_exec($ch);
curl_close($ch);


?>
<section class="main-content">

<?php
$main_string="";
$main_string = (array) json_decode($response);
$lastthreemonthdate = date("y-m-d", strtotime("-3 Months"));
$timelast           = strtotime($lastthreemonthdate);
$keepatime          = 21564000;
$month = 3;
getData(3,$main_string,$asin);
getData(6,$main_string,$asin);
getData(9,$main_string,$asin);
getData(12,$main_string,$asin);
getData('all',$main_string,$asin);
}
}
}
?>

</section>
