<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Fechar Caixa</p>
				</div>
				<div class="card-body">
					<form id="formRegistrarCaixa" action="{URLFORM}" method="post">
						<input type="hidden" name="id" id="id" value="{id}">
						<input type="hidden" name="data" id="data" value="{data}">
						<input type="hidden" name="valor" id="valor" value="{valor}">
						<input type="hidden" name="caixa_id" id="caixa_id" value="{caixa_id}">
					</form>
					<div class="table-responsive">
						<table class="table">
							<thead class=" text-primary">
							<th>
								#
							</th>
							<th>
								Data
							</th>
							<th>
								Valor
							</th>
							</thead>
							<tbody>
							{BLC_DADOS}
							<tr>
								<td>
									{ID}
								</td>
								<td>
									{DATA}
								</td>
								<td class="text-primary">
									R$ {VALOR}
								</td>
							</tr>
							{/BLC_DADOS}
							<tr>
								<td>Valor Total</td>
								<td></td>
								<td>R$ {VALORTOTAL}</td>
							</tr>
							{BLC_SEMDADOS}
							<tr>
								<td colspan="3" class="text-center">Nenhum registro encontrado</td>
							</tr>
							{/BLC_SEMDADOS}
							</tbody>
						</table>
					</div>
					<div class="form-actions">
						<button type="button" id="RegistrarCaixa" class="btn btn-success"><i
								class="material-icons">save</i> Confirmar
						</button>
						<a href="{URLVOLTAR}"
						   class="btn btn-danger"><i
								class="material-icons">reply</i> Voltar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
