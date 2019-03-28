<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de pagamentos</p>
				</div>
				<div class="card-body">
					<form id="FormVendas" action="{ACAOFORM}" method="post">
						<input type="hidden" name="id" id="id" value="{id}">
						<input type="hidden" name="caixa_id" id="caixa_id" value="{caixa_id}">
						<div class="row">
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">nome: </label>
									<input type="text" class="form-control" name="nome" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="control-group">
									<div class="md-form">
										<label for="date-picker-example">Data:</label>
										<input type="date" name="data" id="date-picker-example" class="form-control"
											   value="{data}" required>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="control-group">
									<div class="md-form">
										<label for="">Valor:</label>
										<input type="text" name="valor" id="preco" class="form-control"
											   value="{valor}" required>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<!--Basic textarea-->
								<div class="md-form">
									<textarea type="text" id="textareaBasic" class="form-control md-textarea" rows="3"
											  name="observacao">{observacao}</textarea>
									<label for="textareaBasic">Observação</label>
								</div>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo site_url() ?>painel/pagamento"
							   class="btn btn-danger"><i
									class="material-icons">reply</i> Voltar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
