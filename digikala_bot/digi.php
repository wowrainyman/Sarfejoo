<!-- Digikala Bot -->
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<p class="topStatus">.....</p>
<p class="topStatus2">.....</p>

<?php
	error_reporting(E_ERROR | E_PARSE);
	require_once "config.php";

	if(isset($_GET['lastOne'])){
	    $offset = $_GET['lastOne'] + 1;
	}else{
	    $offset = 0;
	}
	$end = true;
	$queryCategories = "SELECT * FROM digikala_product_related WHERE digikala_id <> 0 ORDER BY id LIMIT 1 OFFSET $offset";

	//$sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
	$result_select_oc = mysqli_query($link_DB, $queryCategories) or die(mysqli_error());
	while ($row = mysqli_fetch_assoc($result_select_oc)) {
	    $end = false;
	    $digikala_product_related = $row;
	}
	if($end){
	    echo 0;
	    return;
	}

	$product_id = $digikala_product_related['digikala_id'];
	$sarfejooProduct_id = $digikala_product_related['sarfejoo_id'];

	echo "Product ID: ".$sarfejooProduct_id;
	$url = "http://digikala.com/Product/DKP-".$product_id;
	echo "<br> Link: ".$url;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);

	$pageBody = preg_replace('#</html>#', '', $data);
	$pageBody = preg_replace('#</body>#', '', $pageBody);

	echo $pageBody;

	?>


<script>
	$(document).ready(function(){

		var $pageLoadTimer = 20000;
   		var $price = $("span[itemprop='price']").attr("content");
   		var $intPrice = parseInt($price);
   		var $condition = false;
   		var $warranty;
   		var $product_id = <?php echo $sarfejooProduct_id ?>

   		// Condition / Mojood / NaMojood
   		$imgCondition = ($("tr[class='status'] img").attr("src"));
   		
   		if ($imgCondition.toLowerCase().indexOf("/available.gif") >= 0){
   			$warranty = $("label[for='ctl08_lstProductWarranty_0']").text();
   			condition = true;
   			// send fresh data to db
			$.ajax({
			    //url: 'http://sarfejoo.com/bot_iran/insDigi.php?product_id=$product_id&price=$price&warranty=$warranty',
			    url: 'http://sarfejoo.com/bot_iran/insDigi.php',
			    type: 'GET',
			    data: { price: $price, warranty:$warranty, product_id:$product_id },
			    success: function(result) {
			        $('.topStatus').text("Price: "+$price);
			        $('.topStatus2').text("Warranty: "+ $warranty);
			    }
			});

   			$pageLoadTimer = 10000;
   		}
   		else{
   			//alert("It's not available");
   			condition = false;
   			//check if product was available but out of stock now.
  
   			$.ajax({
			    //url: 'http://sarfejoo.com/bot_iran/insDigi.php?product_id=$product_id&price=$price&warranty=$warranty',
			    url: 'http://sarfejoo.com/bot_iran/insDigi.php',
			    type: 'GET',
			    data: { price: 0, warranty:"", product_id:$product_id },
			    success: function(result) {
			        //alert('the data was successfully sent to the server');
			        $('.topStatus').text("Price: 0");
			        $('.topStatus2').text("Warranty: ");
			    }
			});

   			$pageLoadTimer = 5000;
   		}
   		
   		//alert($warranty);
            setTimeout(function () {
                window.location.href = "digi.php?lastOne=<?php echo $offset ?>";
            }, $pageLoadTimer);
        });

</script>

</body>
</html>