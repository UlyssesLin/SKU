<!DOCTYPE html>
<!-- Ulysses Lin 12/10/14 -->
<html>
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.get(
                'get_page/1',
                function(data){
                    make_page_table(data);
                },
                'json'
            );
            return false;
        });
        $(document).on('click','.page',function(){
            $('#tbody').children().remove();
            $.get(
                'get_page/'+$(this).attr('id'),
                function(data){
                    make_page_table(data);
                },
                'json'
            );
            return false;
        });
        function make_page_table(data){
            for(i=0;i<data.length;i++){
                $('#tbody').append('<tr><td><img src="'+data[i].src1+'"></td><td>'+data[i].id+'</td><td>'+data[i].item+'</td><td>'+data[i].quantity_sold+'</td><td>'+data[i].inventory+'</td><td><a href="prep_page/'+data[i].id+'"><strong>edit</strong></a> | <a href="delete/'+data[i].id+'"><strong>delete</strong></a></td></tr>');
            }
        }
</script>
</head>

<body>
    <div id="main">
        <div id="dash">
            <h1>DASHBOARD</h1> 
            <a class="right" href="logOut">Logout</a>
            <h3><a class="dashboard" href="/orders">Orders | </a>
                <a class="dashboard" href="/products_page">Products</a>
            </h3>
        </div>

        
        <h2>PRODUCTS VIEW</h2>
        <a class="button" href="add">Add a new product</a>
        <p id="pages">Pages: 
<?php
            for($i=1;$i<=count($all_products);$i++){
?>
                <a class="page" href="#" id="<?= $i ?>"><?= $i ?></a>
<?php
            }
?>
        </p>
        <table>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Inventory Count</th>
                    <th>Quantity Sold</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
</body>
</html>