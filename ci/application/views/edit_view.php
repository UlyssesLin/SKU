<!DOCTYPE html>
<!-- Ulysses Lin 12/10/14 -->
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $type ?> Product</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript">
    
    //Handles image rearrangement
    $(document).on('mouseenter','.image_row',function(){
    	var that=this;
    	var link=$(this).attr('id');
		$(this).find('img').animate({width:'200px',height:'300px'},200);
		$(this).find('img').after('<p><a class="trashes" href="/deleteImage/'+link+'"><img class="trashcan" src="http://cdn-img.easyicon.net/png/5580/558088.png"></a></p>');
		$('.image_row').not(this).find('td').css('border','none');
		$('.image_row').not(this).css("opacity","0.5");
		if($(this).is('.image_row:nth-of-type(1)')){
			$('#left-bar-top').append('<p>MAIN</p>');
			$('#left-bar-top p').animate({opacity:'1'},200);
		}
		$(that).mouseleave(function(){
			$(this).find('img').finish();
			$('#left-bar p').remove();
			$('.image_row img').css({width:'100px',height:'150px'});
			$('.image_row').css("opacity","1");
			$('.image_row td').css('border','dotted gray 1px');
			$('.image_row:nth-of-type(1) td').css('border','dotted RGB(255,0,174) 1px');
		});
	});
	//Handles image deletion
	$(document).on('click','.trashes',function(){
		$('#left-bar-top p').remove();
		$('.image_row td').css('border','dotted gray 1px');
		$('.image_row:nth-of-type(1) td').css('border','dotted RGB(255,0,174) 1px');
        $(this).parent().parent().parent().remove();
        var href=$(this).attr('href')
        var result=href.split('/');
        $.get(
            $(this).attr('href'),
            function(data){
                console.log('deleted this image: '+result[2]+'/'+data[result[2]]);
            },
            'json'
        );
        return false;
    });
	
   	//Category effects; show edit and delete icons
   	$(document).on('mouseenter','.category',function(){
   		$('.category').removeClass('bold');
   		$(this).toggleClass('bold');
   		$(this).append('<img id="category-edit" class="trashcan" href="/updateCategory/'+$(this).attr('cat')+'" src="https://cdn2.iconfinder.com/data/icons/windows-8-metro-style/512/edit.png"><img id="category-trash" class="trashcan" href="/deleteCategory/'+$(this).attr('cat')+'" src="http://cdn-img.easyicon.net/png/5580/558088.png">');
   		$(this).mouseleave(function(){
   			$(this).toggleClass('bold');
   			$(this).find('img').remove();
   		});
   	});
   	//Select actual category
   	$(document).on('click','.category',function(){
   		$('#chosen-category').removeAttr('id');
   		$(this).attr('id','chosen-category');
   		$.get(
			'/setCategory/'+$(this).attr('cat'),
			function(data){
				console.log('category set to: '+data['PRODUCT CATEGORY']);
			},
			'json'
		);
		return false;
   	})
   	//Update category & Delete category
   	$(document).on('click','#category-trash,#category-edit',function(){
   		var link=$(this).attr('href');
   		//Delete category
   		if($(this).attr('id')=='category-trash'){
   			var delete_cat=$(this).parent().attr('cat');
   			$(this).parent().remove();
   			$.get(
				link,
				function(data){
					console.log('changed: '+$(this).parent().attr('cat'));
				},
				'json'
			);
			return false;
		//Update category
   		}else{
			var that_inner=$(document).find("p[cat="+$(this).parent().attr('cat')+"]");
			var old_cat=(that_inner.text());
			$(this).parent().replaceWith('<textarea id="small-textarea">'+old_cat+'</textarea><button id="change">Change</button>');
			$(document).one('click','#change',function(){
				var new_cat=$('#small-textarea').val();
				that_inner=$(that_inner).empty();
				$(that_inner).text(new_cat);
				$(that_inner).removeClass('bold');
				$('#change').remove();
				$('#small-textarea').replaceWith(that_inner);
				$.get(
					link+'/'+new_cat,
					function(data){
						console.log(data);
					},
					'json'
				);
				return false;
   			});
		}
		
   	});
	//Makes images sortable
	$(document).ready(function(){
	    $('#image-table tbody').sortable();
	});
	//Submits form (update/add)
	$(document).on('submit','#edit',function(){
		//'that' remembers the delete form
		var that=this;
		var order='';
		$('#image-table tr').each(function(){
			order+=$(this).attr('which');
		});
		if($('.image_row').length){
			$.ajax({
				url: '/organizeImages/'+order,
				dataType: 'json'
			})
		}
		$.post(
			$(this).attr('action'),
			$(this).serialize(),
			function(data){
				$('h1').before('<h4>Database updated!</h4><a class="pink" href="/products_page">Click HERE to return to products page</a>');
			},
			'json'
		);
		return false;
	});
</script>
</head>

<body>
	
<?php
	if(empty($product_info['item'])){
?>
		<h1 class="blah">Add a new product:</h1>
<?php
	}else{
?>
		<h1 class="blah">Edit Product - <?= $product_info['item'] ?> - ID: <?= $product_info['id'] ?></h1>
<?php
	}
?>
	<div id="left-bar">
		<div id="left-bar-top">
		</div>
		<table id="image-table">
			<tbody>
<?php
			if($product_info['id']!='NEW'){
				$i=1;
				foreach($srcs_array as $src){
?>
					<tr id="<?= $product_info['id'] ?>/<?= $i ?>" which="<?= $i ?>" class="image_row"><td><img src="<?= $src ?>"></td></tr>
<?php
					$i++;
				}
			}
?>
			</tbody>
		</table>
	</div>
	<div id="main">
		<div id="main-top">
		</div>
		<form id="edit" action="/update/<?= $product_info['id'] ?>">
		<table id="data">
			<tr><td>Name </td><td><input type="text" name="item" value="<?= $product_info['item'] ?>"></td></tr>
			<tr><td>Description </td><td><textarea name="description"><?= $product_info['description'] ?></textarea></td></tr>
			<tr><td>Categories </td>
				<td>
<?php
					$add_default_cat=false;
					if($type=='Add'){
						$add_default_cat=true;
					}
					foreach($categories as $category){
						if(($type=='Update' && $category['id']==$product_info['category_id']) | $add_default_cat){
?>
							<div><p id="chosen-category" cat="<?= $category['id'] ?>" class="category"><?= $category['category'] ?></p></div>
<?php
							$add_default_cat=false;
						}else{
?>
						<div><p cat="<?= $category['id'] ?>" class="category"><?= $category['category'] ?></p></div>
<?php
						}
					}
?>
				</td>
			</tr>
			<tr><td>or add a new category </td><td><input type="text" name="category_new"></td></tr>
		</table>
		<input type="submit" name="update" value="<?= $type ?>">
	</form>
	<a class="button" href="/products_page">Cancel</a>
	<a class="button" href="#">Preview</a>
	<span id="warning"><?= $this->session->flashdata('errors') ?></span>
</div>
</body>
</html>