<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de clientes</p>
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
									<label class="bmd-label-floating">Telefone</label>
									<input type="text" name="telefone" id="telefone" class="form-control" value="{telefone}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Email</label>
									<input type="text" name="email" id="email" class="form-control" value="{email}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="control-group">
									<div class="md-form">
										<label for="date-picker-example">Data de Nascimento:</label>
										<input type="date" name="datanascimento" id="date-picker-example" class="form-control"
											   value="{datanascimento}" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Cep</label>
									<input type="text" name="cep" id="cep" class="form-control" value="{cep}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Rua</label>
									<input type="text" name="rua" id="rua" class="form-control" value="{rua}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Bairro</label>
									<input type="text" name="bairro" id="bairro" class="form-control" value="{bairro}" required="required">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">Cidade</label>
									<input type="text" name="cidade" id="cidade" class="form-control" value="{cidade}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="bmd-label-floating">UF</label>
									<input type="text" name="uf" id="uf" class="form-control" value="{uf}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Observação</label>
									<div class="form-group">
										<textarea name="observacao" class="form-control" rows="5" >{observacao}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/cliente"
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
