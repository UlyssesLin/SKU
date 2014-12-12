<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>SKU View One</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/storeview.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">
    	$(document).on('keyup','#SearchForm',function(){
    		console.log('submitted');
    		$('#products-container').html('');
            $.post(
                $(this).attr("action"),
                $(this).serialize(),
                function(names_received){
                	if((names_received).length!=0){
                		console.log(names_received);
                		for(i=0;i<names_received.length;i++){
                			console.log(names_received[i].src1);
                			$('#products-container').append('<div class="product"><a href="/product/'+names_received[i].id+'"><img class="main-image" src="'+names_received[i].src1+'"></a><p class="product-name">'+names_received[i].item+'</p><p class="price">'+names_received[i].price+'</p></div>');
                		}
                	}
                },
                "json"
            );
            return false;
    	});
    </script>
<!--     <div class="product">
			<a href="/product/<?= $item['id'] ?>">
	 			<img class="main-image" src='<?= $item['src1'] ?>'>
			</a>
			
			<p class="product-name"><?= $item['item'] ?> </p>

			<p class="price"><?= $item['price'] ?> </p>
		</div> -->
</head>
<body>

<div id="container">
	<div class="header"></div>
	<a href='/checkout'>
		<h3>SHOPPING BAG</h3>
	</a>
	<a href="/"><h1>S.K.U.</h1></a>
	<div id='nav'>
		<ul>
			<a href='/category/1'><li>SHIRTS</li></a>
			<a href='/category/2'><li>PANTS</li></a>
			<a href='/category/3'><li>DRESSES</li></a>
			<a href='/category/4'><li>SWEATERS</li></a>
			<a href='/category/5'><li>OUTERWEAR</li></a>
		</ul>
		<form id="SearchForm" action="/findItems">
			<input type="search" placeholder="WHAT CAN WE HELP YOU FIND?" name="searchPhrase">
		</form>
	</div>
	
	<div id="image-header">
		<img src="https://www.madewell.com/media/assets/NewHP/img0_v1_m56577569830605389.jpg" border="0">
	</div>
	<div id="products-container-wrapper">
		<div id="products-container">

<?php
if($items!=null){
	foreach($items as $item){
?>
			<div class="product">
				<a href="/product/<?= $item['id'] ?>">
		 			<img class="main-image" src='<?= $item['src1'] ?>'>
				</a>
				
				<p class="product-name"><?= $item['item'] ?> </p>

				<p class="price"><?= $item['price'] ?> </p>
			</div>
<?php 
	}
}
?>
		</div>
	</div>

	<div class="footer-pagination">
    	<ul>

    	</ul>    
	</div>

	<div id="footer">
		<p class="nestled"><a class="white" href="/logins">Admin</a></p>
		<p class="nestled">© 2014 S.K.U.</p>
	</div>


</div>

</body>
</html>