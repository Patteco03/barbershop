<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="utf-8"/>
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('') . "assets/"; ?>dashboard/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url('') . "assets/"; ?>dashboard/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>
		Painel Administrativo
	</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		  name='viewport'/>
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css"
		  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
	<!-- CSS Files -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/css/material-dashboard.css?v=2.1.0" rel="stylesheet"/>
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/demo/demo.css" rel="stylesheet"/>
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/css/jquery-confirm.css" rel="stylesheet"/>
	<!-- MDBootstrap Datatables  -->
	<link href="<?php echo base_url('') . "assets/"; ?>dashboard/addons/datatables.min.css" rel="stylesheet">
	<link href="<?php echo base_url('') . "assets/"; ?>style.css" rel="stylesheet">
	<!-- SEARCH SELECT-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

</head>

<body class="">
<div class="wrapper ">
	<div class="sidebar" data-color="purple" data-background-color="white"
		 data-image="<?php echo base_url('') . "assets/"; ?>dashboard/img/sidebar-1.jpg">
		<!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
		<div class="logo">
			<a href="<?php echo site_url('painel') ;?>" class="simple-text logo-normal">
				Vikings Barbeshop
			</a>
		</div>
		<div class="sidebar-wrapper">
			<ul class="nav">
				<li class="nav-item active  ">
					<a class="nav-link" href="<?php echo base_url('/painel');?>">
						<i class="material-icons">dashboard</i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/caixa') ;?>">
						<i class="material-icons">attach_money</i>
						<p>Caixa</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/vendas') ;?>">
						<i class="material-icons">gavel</i>
						<p>Vendas</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/pagamento') ;?>">
						<i class="material-icons">exit_to_app</i>
						<p>Saída</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/cliente') ;?>">
						<i class="material-icons">person</i>
						<p>Cliente</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/product') ;?>">
						<i class="material-icons">card_giftcard</i>
						<p>Produto</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/service') ;?>">
						<i class="material-icons">bubble_chart</i>
						<p>Serviços</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/barber') ;?>">
						<i class="material-icons">people</i>
						<p>Barbeiro</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/comissao') ;?>">
						<i class="material-icons">assignment</i>
						<p>Comissão</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/permissoes') ;?>">
						<i class="material-icons">vpn_key</i>
						<p>Permissões</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/users') ;?>">
						<i class="material-icons">how_to_reg</i>
						<p>Usuários</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/relatorio') ;?>">
						<i class="material-icons">bar_chart</i>
						<p>Relatórios</p>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="<?php echo site_url('painel/login/sair') ;?>">
						<i class="material-icons">person</i>
						<p>Sair</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="main-panel">
		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-brand" href="#pablo">Dashboard</a>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
						aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
			</div>
		</nav>
		<!-- End Navbar -->
		<div class="content">
			{MENSAGEM_SISTEMA_ERRO}
			{MENSAGEM_SISTEMA_SUCESSO}
			{CONTEUDO}
		</div>
		<footer class="footer">
			<div class="container-fluid">
				<div class="copyright float-right">
					&copy;
					<script>
						document.write(new Date().getFullYear())
					</script>
				</div>
			</div>
		</footer>
	</div>
</div>

<input type="hidden" id="siteURL" class="siteURL" name="siteURL" value="<?php echo site_url() ;?> ">
<!--   Core JS Files   -->
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/core/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/core/bootstrap-material-design.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- SEARCH SELECT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Chartist JS -->
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/material-dashboard.min.js?v=2.1.0"
		type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="<?php echo base_url('') . "assets/"; ?>dashboard/addons/datatables.min.js"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/demo/demo.js"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/jquery-confirm.js"></script>
<script src="<?php echo base_url('') . "assets/"; ?>dashboard/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url('') . "assets/"; ?>main.js"></script>
<script>
	$(document).ready(function () {
		// Javascript method's body can be found in assets/js/demos.js
		md.initDashboardPageCharts();

	});
	function removeElement(parentDiv, childDiv) {
		if (childDiv == parentDiv) {
			alert("The parent div cannot be removed.");
		}
		else if (document.getElementById(childDiv)) {
			var child = document.getElementById(childDiv);
			var parent = document.getElementById(parentDiv);
			parent.removeChild(child);
		}
		else {
			alert("Child div has already been removed or does not exist.");
			return false;
		}
	}
</script>
</body>

</html>
