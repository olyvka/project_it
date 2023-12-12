<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
	header('location:admin_book.php');
}
	$title = "Admin Panel";
	require_once "./template/header.php";
?>
<style>
	 body {
          background-color: #e8ebe9;
        }
        h1 {
          color: #0a3b1b;
        }
</style>
<div class="row justify-content-center my-5">
	<div class="col-lg-4 col-md-6 col-sm-10 col-xs-12">
		<div class="card rounded-3 shadow">
			<div class="card-header">
				<div class="card-title text-center h4 fw-bolder">Вхід</div>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<?php if(isset($_SESSION['err_login'])): ?>
						<div class="alert alert-danger rounded-3">
							<?= $_SESSION['err_login'] ?>
						</div>
					<?php 
						unset($_SESSION['err_login']);
						endif;
					?>
					<form class="form-horizontal" method="post" action="admin_verify.php">
						<div class="mb-3">
							<label for="name" class="control-label ">Логін</label>
							<input type="text" name="name" class="form-control rounded-3">
						</div>
						<div class="mb-3">
							<label for="pass" class="control-label ">Пароль</label>
							<input type="password" name="pass" class="form-control rounded-3">
						</div>
						<div class="mb-3 d-grid">
							<input type="submit" name="submit" class="btn btn-primary rounded-3">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	

<?php
	require_once "./template/footer.php";
?>