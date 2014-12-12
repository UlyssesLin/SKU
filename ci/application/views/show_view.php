<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/show_style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
    <div id="main">
        <div class='addresses'>
            <h3 class='borderbottom gray'>Order ID: <?=$purchases[0]['OrdersID']?></h3>
            <table class='customer-details border-bottom'>
                <tr><td colspan='2'><p class='center'>Customer Shipping Info:</p></td></tr>
                <tr><td>Name: </td><td><?=$shipping['first_name'] . " " . $shipping['last_name']?></td></tr>
                <tr><td>Address: </td><td><?=$shipping['address_1']?></td></tr>
                <tr><td>City: </td><td><?=$shipping['city']?></td></tr>
                <tr><td>State: </td><td><?=$shipping['state']?></td></tr>
                <tr><td>Zip: </td><td><?=$shipping['zip']?></td></tr>
            </table>
            <table class='customer-details border-bottom'>
                <tr><td colspan='2'><p class='center'>Customer Billing Info:</p></td></tr>
                <tr><td>Name: </td><td><?=$billing['first_name'] . " " . $billing['last_name']?></td></tr>
                <tr><td>Address: </td><td><?=$billing['address_1']?></td></tr>
                <tr><td>City: </td><td><?=$billing['city']?></td></tr>
                <tr><td>State: </td><td><?=$billing['state']?></td></tr>
                <tr><td>Zip: </td><td><?=$billing['zip']?></td></tr>
            </table>
        </div><!--
     --><div class='purchases'>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="tbody">
<?php   $subTotal = 0;
        foreach ($purchases as $purchase) {
            $prodTotal = $purchase['price']*$purchase['quantity'];
            $prodTotal = number_format($prodTotal, 2);                 ?>                                               
                <tr>
                    <td><?=$purchase['PurchaseID']?></td>
                    <td><?=$purchase['item']?></td>
                    <td><?=$purchase['price']?></td>
                    <td><?=$purchase['quantity']?></td>
                    <td><?=$prodTotal?></td>
                </tr>
<?php   $subTotal +=$prodTotal;
        }
        $subTotal = number_format($subTotal, 2);  
        $total =  $subTotal + $purchase['shipping_cost'];
        $total = number_format($total, 2);                              ?>
                <tr class='ship-status'><td colspan='5'> Status: <span class='pink'><?=$purchases[0]['SHIPPING']?></span></td></tr>
                <tr class='totals'><td class='noborder' colspan='4'></td>
                    <td colspan='1' class='noborder left'><span class='cost'>Sub-total: <?=$subTotal?></span></td>
                </tr>
                <tr class='totals'><td class='noborder' colspan='4'></td>
                    <td colspan='1' class='noborder left'><span class='cost'>Shipping: <?=$purchase['shipping_cost']?></span></td>
                </tr>
                <tr class='totals'><td class='noborder' colspan='4'></td>
                    <td colspan='1' class='left bordertop'><span class='cost'>Total Price: <?=$total?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>