<?php   
        $orders = $this->session->userdata('orders');
                                                      ?>
<!DOCTYPE html>
<!-- Sara Wong 12/11/14 -->
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/order_style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.get(
                'order_page/1',
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
                'order_page/'+$(this).attr('id'),
                function(data){
                    make_page_table(data);
                },
                'json'
            );
            return false;
        });
        $(document).on('keyup','.searchPhrase',function(){
            var x = $('input[name="searchPhrase"]').val();
            if(x.length==0){
                x = 'all';
            }
            $.get(
                '/search/' + x,
                function(data){
                    $('#tbody').children().remove();
                    make_page_table(data);
                    $('#pages').children().remove();
                    for(var i=1; i<=data['pages']; i++){
                        $('#pages').append('<a class="page" href="#" id="' + i + '"> ' + i + ' </a>');
                    }
                },
                'json'
            );
            // return false;
        });
        $(document).on('click','.status',function(){
            var status = $(this).val();
            var that = $(this).parent();
            $.get(
                'status_change/' + $(this).parent().parent().parent().attr('class') + "/" + $(this).val(),
                function(data){
                    if(status==0){
                        status='Cancelled';
                    }
                    else if(status==1){
                        status='Order in Progress';
                    }
                    else{
                        status='Shipped';
                    }
                    (that).replaceWith(make_ship_status(status));
                },
                'json'
            );
            return false;
        });
        function make_ship_status($status){
            var fullString="<form>"
            if($status=='Shipped'){
                fullString = fullString + "<input type='radio' class='status' value='0'> Cancelled " +
                "<input type='radio' class='status' value='1'> Order in Progress " + "<input type='radio' class='status' checked='checked' value='2'> Shipped ";
            }
            else if($status=='Order in Progress'){
                fullString = fullString + "<input type='radio' class='status' value='0'> Cancelled "+
                "<input checked='checked' type='radio' class='status' value='1'> Order in Progress " + "<input type='radio' class='status' value='2'> Shipped ";
            }
            else {
                fullString = fullString + "<input checked='checked' type='radio' class='status' value='0'> Cancelled "+
                "<input type='radio' class='status' value='1'> Order in Progress " + "<input type='radio' class='status' value='2'> Shipped ";
            }
            fullString = fullString + "</form>";
            return fullString;
        }
        function make_page_table(data){
            for(var i=0;i<Object.keys(data).length-1;i++){
                $('#tbody').append("<tr class='"+data[i].id+"'><td class='small'><a class='id-link' href='/show/"+
                    data[i].id+"'>" + data[i].id + "</a></td><td class='small'>"+data[i].first_name+' '+data[i].last_name+
                    "</td><td class='date'>"+data[i].purchase_date+"</td><td class='address'>"+data[i].address_1 + " " + 
                    data[i].city + ", " + data[i].state + " " +  data[i].zip + " " + 
                    "</td><td class='small'>"+data[i].TOTAL+"</td><td class='shipStatus'>"+ make_ship_status(data[i].ship_status) +
                    '</td></tr>');
            }
        }
</script>
</head>

<body>
    <div id="main">
        <h1 id="dash">DASHBOARD<a class="dashboard" href="/orders">Orders</a><a class="dashboard" href="/products_page">Products</a></h1>
        <a class="right" href="logOut">Logout</a>
        <h1 class='round'>ORDERS VIEW</h1>
        <div id="search">
            <input type="search" placeholder="SEARCH NAME, DATE, OR ORDER ID..." name="searchPhrase" class='searchPhrase'>
        <div id="pages">
            Pages:
<?php
            for($i=1;$i<=count($orders);$i++){
?>
                <a class="page" href="#" id="<?= $i ?>"><?= $i ?></a>
<?php
            }
?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Billing Address</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
</body>
</html>