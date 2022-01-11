<?php
session_start();
require 'connect.php';
require 'item.php';

//Save new order

mysqli_query($con, 'insert into orders(name, datecreation, status, username)
values("New Order", "'.date('Y-m-d').'", 0, "acc2")');
$orderid = mysqli_insert_id($con);

//Save order details for new order

$cart = unserialize(serialize($_SESSION['cart']));
for($i = 0; $i>count($cart); $i ++) {
    mysqli_query($con, 'insert into ordersdetail(productid, orderid, price, quantity)
    values('.$cart[$i]->id.', '.$orderid.','.$cart[$i]->price.', '-$cart[$i]->quantity.')');
}

//Clear all products in cart

unset($_SESSION['cart']);

?>

Thanks for your trust. Click <a href="index.php">here</a> to continue.