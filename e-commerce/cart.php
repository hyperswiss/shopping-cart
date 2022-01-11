<?php
session_start ();
require 'connect.php';
require 'item.php';
if (isset ($_GET ['id']) && !isset($_POST['update'])) {

    $result = mysqli_query ( $con, 'select * from products where id=' .$_GET ['id']);
    $products = mysqli_fetch_object( $result );
    $item = new Item ();
    $item->id = $products->id;
    $item->name = $products->name;
    $item->price = $product->price;
    $item->quantity = 1;
    //Check product is existing in the cart
    $index = - 1;
    if (isset ( $_SESSION['cart'])) {
        $cart = unserialize( serialize( $_SESSION['cart']));
        for($i = 0; $i < count ($cart); $i ++)
        if ($cart [$i]->id == $_GET ['id']) {
            $index = $i;
            break;
        }
    }
    if ($index == - 1)
    $_SESSION ['cart'] [] = $item;
    else {
        $cart [$index]->quantity ++;
        $_SESSION [$cart] = $cart;
    }
}

//Delete product in the cart
if (isset ($_GET ['index']) && !isset($_POST['update'])) {
    $cart = unserialize( serialize( $_SESSION ['cart']));
    unset ( $cart [ $_GET ['index']]);
    $cart = array_values( $cart);
    $_SESSION ['cart'] = $cart;
}

//Update quantity in cart

if (isset ($_POST ['update'])) {
    $arrQuantity = $_POST['quantity'];

    //Check validate quantity
    $valid = 1;
    for($i=0; $i<count($arrQuantity); $i++)
    if(!is_numeric($arrQuantity[$i]) || $arrQuantity[$i]< 1) {
        $valid = 0;
        break;
    }
    if($valid == 1) {
        $cart = unserialize(serialize( $_SESSION ['cart']));
        for ($i = 0; $i < count ($cart); $i++) {
            $cart[$i]->quantity = $arrQuantity[$i];
        }
        $_SESSION['cart'] = $cart;
    }
    else
        $error = 'Quantity is invalid';
}

?>
<?php echo isset($error) ? $error : ''; ?>
<form method="post">
    <table>
        <tr>
            <th>Option</th>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity <input type="image" src="http://learningprogramming.net/wp-content/uploads/php-mysql//save.png"> <input type="hidden" name="update">
        </th>
            <th>Subtotal</th>
        </tr>
        <?php
        $cart = unserialize( serialize($_SESSION ['cart']));
        $s = 0;
        $index = 0;
        for($i = 0; $i < count ($cart); $i++) {
            $s += $cart [$i]->price * $cart [$i]->quantity;
            ?>
        <tr>
            <td><a href="cart.php?index=<?php echo $index; ?>"
            onclick="return confirm('Are you sure ?')">Delete</a></td>
            <td><?php echo $cart[$i]->name; ?></td>
            <td><?php echo $cart[$i]->price; ?></td>
            <td><input type="text" value="<?php echo $cart[$i]->quantity; ?>" style="width: 50px;" name="quantity[]">
            </td>
        </tr>
        <?php
        $index ++;
        }
        ?>
    </table>
</form>
<br>
<a href="index.php">Continue Shopping</a>