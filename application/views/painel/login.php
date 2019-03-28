
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Material Design Bootstrap</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/css/mdb.min.css" rel="stylesheet">
	<!-- Your custom styles (optional) -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/css/style.css" rel="stylesheet">
</head>

<body>

<!-- Start your project here-->
<div style="height: 100vh">
	<div class="flex-center flex-column">
		<!-- Default form subscription -->
		<form action="<?php echo site_url('painel/login/verifica');?>" class="text-center border border-light p-5" method="post">
			{MENSAGEM_SISTEMA_ERRO}
			<p class="h4 mb-4">Login</p>

			<p>Faça o login para entra na plataforma do Barbeshop.</p>

			<!-- Name -->
			<input type="text" name="username" id="defaultSubscriptionFormEmail" class="form-control mb-4" placeholder="Usuário">

			<!-- Email -->
			<input type="password" name="password" id="defaultSubscriptionPassword" class="form-control mb-4" placeholder="Senha">

			<!-- Sign in button -->
			<button class="btn btn-info btn-block" type="submit">Login</button>

		</form>
		<!-- Default form subscription -->
	</div>
</div>
<!-- /Start your project here-->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="<?php echo base_url('') . "assets/"; ?>dashboard/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url('') . "assets/"; ?>dashboard/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('') . "assets/"; ?>dashboard/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('') . "assets/"; ?>dashboard/js/mdb.min.js"></script>
</body>

</html>
