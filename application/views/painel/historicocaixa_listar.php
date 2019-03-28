<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="Exiberro"></div>
						<div class="col-md-3">
							<div class="control-group">
									<label class="bmd-label-floating" for="">Selecione uma data:</label>
									<select name="data" class="form-control" id="dataConsulta" required>
										{BLC_DADOS}
										<option value="{DATACONSULTA}" > {DATA}</option>
										{/BLC_DADOS}
									</select>
							</div>
						</div>
						<div class="col-md-3">
							<button id="consultarHistorico" class="btn" type="button">Consultar</button>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="listHistorico" id="">
								<ul class="list-group list-group-flush" id="listHistorico">
									<div class="valorvenda"></div>
									<div class="valorsaida"></div>
									<div class="valorsaldo"></div>
								</ul>
							</div>
						</div>
					</div>
					<br><br><br><br>
					<div class="form-actions">
						<a href="{URLVOLTAR}"
						   class="btn btn-danger"><i
								class="material-icons">reply</i> Voltar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
