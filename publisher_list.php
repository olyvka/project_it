<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$query = "SELECT * FROM publisher ORDER BY publisherid";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	if(mysqli_num_rows($result) == 0){
		echo "Empty publisher ! Something wrong! check again";
		exit;
	}

	$title = "List Of Publishers";
	require "./template/header.php";
?>
<style>
   body {
          background-color: #e8ebe9;
        }
        h1 {
          color: #0a3b1b;
        }
		

</style>
	<div class="h5 fw-bolder text-center">Список Видаництв</div>
	<hr>
	<div class="list-group">
		<a class="list-group-item list-group-item-action" href="books.php">
			Виберіть Видаництво
		</a>
	<?php 
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT publisherid FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($pubInBook = mysqli_fetch_assoc($result2)){
				if($pubInBook['publisherid'] == $row['publisherid']){
					$count++;
				}
			}
	?>
		<a class="list-group-item list-group-item-action" href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>">
			<span class="badge badge-primary bg-success rounded-pill"><?php echo $count; ?></span>
			<?php echo $row['publisher_name']; ?>
		</a>
	<?php } ?>
	</div>
<?php
	mysqli_close($conn);
	require "./template/footer.php";
?>