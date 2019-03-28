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
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Nome</label>
									<input type="text" name="nome" class="form-control" value="{nome}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">R$ </label>
									<input type="text" name="porcentagem" id="porcentagem" class="form-control" value="{valor}" required="required">
								</div>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/comissao"
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
