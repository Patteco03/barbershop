<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de categoria</p>
				</div>
				<div class="card-body">
					<form action="{ACAOFORM}" method="post">
						<input type="hidden" name="id" id="id"
							   value="{id}">

						<div class="row">
							<div class="col-md-5">
								<div class="control-group">
									<label class="bmd-label-floating" for="nome">Nome: </label>
									<input type="text" name="name" class="form-control" id="nome" value="{name}" required>
								</div>
							</div>
						</div>

						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/product"
							   class="btn btn-danger"><i
									class="material-icons">reply</i> Voltar</a>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
