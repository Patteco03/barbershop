<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de barbeiro</p>
				</div>
				<div class="card-body">
					<form action="{ACAOFORM}" method="post">
						<div class="row">
							<input type="hidden" name="id" id="id" value="{id}">
							<input type="hidden" name="idproduto" id="idproduto" value="{idproduto}">
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">{nomeproduto}</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Quantidade</label>
									<input type="text" name="quantidade" id="quantidade" class="form-control" value="{quantidade}" required="required">
								</div>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Atualizar
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
