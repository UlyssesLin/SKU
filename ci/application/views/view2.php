<!doctype html>

<html>
<head>
  <meta charset="UTF-8">
  <title>SKU View Two</title>
  <link rel="stylesheet" type="text/css" href="/assets/css/storeview.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/JavaScript">
    $(document).ready(function() {
      // var old_main=$('.large').attr('src');
      // console.log(old_main);
      $(".thumbnails img").hover(function(){
          $('.large').attr('src',$(this).attr('src'));
          // $(this).attr('src',old_main);
      });

      var imgSwap = [];
      //  $(".thumbnails img").each(function(){
      //     imgUrl = this.src.replace('thumb/', '');
      //     imgSwap.push(imgUrl);
      // });
      $(imgSwap).preload();
  });
  $.fn.preload = function() {
      this.each(function(){
          $('<img/>')[0].src = this;
      });
  }
  </script>
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
    <form id="SearchForm" action="">
      <input type="search" placeholder="WHAT CAN WE HELP YOU FIND?" name="searchPhrase">
    </form>
  </div>

    <div id="product-page">

          <div id="product-images">
              <img class="large" src='<?=$item['src1']?>'>

              <div class="thumbnails">
                <div class="thumbnail-wrapper"><img src='<?= $item['src2'] ?>'></div>
                <div class="thumbnail-wrapper"><img src='<?= $item['src3'] ?>'></div>
                <div class="thumbnail-wrapper"><img src='<?= $item['src4'] ?>'></div>
              </div>
          </div>

          <div id="product-details">
              
              <h2><?=$item['item']?></h2>
              <h2><?=$item['price']?></h2>

              <details>
               <summary>Product Description</summary>   
                    <p><?=$item['description']?></p>
              </details>

              <form class="add-to-bag" action="/shoppingbag/<?=$item['id']?>" method="post">
                  <select name='quantity'>
                      <option value="1">Quantity</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                  </select>
                  <input class="button" type="submit" value="Add to Bag">
              </form>

        </div>
    </div>
</div> 
                <div id='similar'>
                  <h2>Similar Items</h2>
<?php 
  foreach ($similars as $similar) {
?>
                <div class="sim"><a href='/product/<?= $similar["id"] ?>'><img class="similar" src='<?=$similar["src1"]?>'></a><h6><?=$similar["item"]?></h6></div>
<?php  
}
 ?>
              </div>
  <div id="footer">
    <p class="nestled"><a class="white" href="/logins">Admin</a></p>
    <p class="nestled">© 2014 S.K.U.</p>
  </div>

</body>
</html>



