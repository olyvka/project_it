<?php
	// the shopping cart needs sessions, to start one
	/*
		Array of session(
			cart => array (
				book_isbn (get from $_POST['book_isbn']) => number of books
			),
			items => 0,
			total_price => '0.00'
		)
	*/
	session_start();
	require_once "./functions/database_functions.php";
	require_once "./functions/cart_functions.php";

	// book_isbn got from form post method, change this place later.
	if(isset($_POST['bookisbn'])){
		$book_isbn = $_POST['bookisbn'];
	}

	if(isset($book_isbn)){
		// new iem selected
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] is associative array that bookisbn => qty
			$_SESSION['cart'] = array();

			$_SESSION['total_items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}

		if(!isset($_SESSION['cart'][$book_isbn])){
			$_SESSION['cart'][$book_isbn] = 1;
		} elseif(isset($_POST['cart'])){
			$_SESSION['cart'][$book_isbn]++;
			unset($_POST);
		}
	}

	// if save change button is clicked , change the qty of each bookisbn
	if(isset($_POST['save_change'])){
		foreach($_SESSION['cart'] as $isbn =>$qty){
			if($_POST[$isbn] == '0'){
				unset($_SESSION['cart']["$isbn"]);
			} else {
				$_SESSION['cart']["$isbn"] = $_POST["$isbn"];
			}
		}
	}

	// print out header here
	$title = "Your shopping cart";
	require "./template/header.php";
?>
	<h4 class="fw-bolder text-center">Кошик</h4>
      <center>
        <hr class="bg-success" style="width:5em;height:3px;opacity:1">
      </center>
<?php
	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['total_items'] = total_items($_SESSION['cart']);
?>
<style>
   body {
          background-color: #e8ebe9;
        }
        h1 {
          color: #0a3b1b;
        }
		td, th {
			color: #0a3b1b;
		}
		.btn {
			border-radius: 10;
			color: white;
			background-color: #0a3b1b;
		}
		

</style>
	<div class="card rounded-10 shadow">
		<div class="card-body">
			<div class="container-fluid">
				<form action="cart.php" method="post" id="cart-form">
					<table class="table">
						<tr>
							<th>Товар</th>
							<th>Ціна</th>
							<th>Кількість</th>
							<th>Сума</th>
						</tr>
						<?php
							foreach($_SESSION['cart'] as $isbn => $qty){
								$conn = db_connect();
								$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
						?>
						<tr>
							<td><?php echo $book['book_title'] . " by " . $book['book_author']; ?></td>
							<td><?php echo "$" . $book['book_price']; ?></td>
							<td><input type="text" value="<?php echo $qty; ?>" size="2" name="<?php echo $isbn; ?>"></td>
							<td><?php echo "$" . $qty * $book['book_price']; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th><?php echo $_SESSION['total_items']; ?></th>
							<th><?php echo "$" . $_SESSION['total_price']; ?></th>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="card-footer text-end">
			<input type="submit" class="btn btn-primary rounded-10" name="save_change" value="Зберегти зміни" form="cart-form">
			<a href="checkout.php" class="btn btn-dark rounded-10">Оформити замовлення</a> 
			<a href="books.php" class="btn btn-success rounded-10">Продовжити покупки</a>

		</div>
	</div>
	
<?php
	} else {
		?>
<div class="alert alert-success rounded-3">Ваш кошик порожній! Спочатку додайте принаймні 1 книгу для покупки.</div>
<?php

	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>