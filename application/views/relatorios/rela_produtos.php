<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div id="content">
						Relatórios de Produtos
					</div><!-- /content -->
				</div>
				<div class="card-body">
					<form action="{URLFORM}" method="post" id="">

						<div class="row">
							<div class="col-md-3">
								<div class="control-group">
									<div class="md-form">
										<label for="date-picker-example">Data Inicio:</label>
										<input type="date" name="datainicio" id="date-picker-example"
											   class="form-control"
											   value="{datainicio}" required>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="control-group">
									<div class="md-form">
										<label for="date-picker-example">Data Final:</label>
										<input type="date" name="datafinal" id="date-picker-example"
											   class="form-control"
											   value="{datafinal}" required>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Buscar
							</button>
							<a href="<?php echo site_url() ?>painel/relatorio"
							   class="btn btn-danger"><i
									class="material-icons">reply</i> Voltar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


