<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title ">Vendas</h4>
					<div class="pull-right">
						<a href="{URLLISTAR}" title="Listar">
							<button type="button" class="btn btn-primary"><i class="material-icons">autorenew</i> Listar
							</button>
						</a>
						<a href="{URLADICIONAR}" title="Adicionar">
							<button type="button" class="btn btn-primary"><i class="material-icons">add</i> Adicionar
							</button>
						</a>
					</div>
				</div>
				<div class="card-body">
					<table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead class="text-primary">
						<tr>
							<th class="th-sm">#
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
							<th class="th-sm">Nome
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
							<th class="th-sm">Cupom
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
							<th class="th-sm">Status
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
							<th class="th-sm">Editar / Excluir
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
						</tr>
						</thead>
						<tbody>
						{BLC_DADOS}
						<tr>
							<td>{ID}</td>
							<td>{NOME}</td>
							<td>{CUPOM}</td>
							<td>{STATUS}</td>
							<td>
								<a href="{URLEXCLUIR}" id="delete" title="Excluir" rel="tooltip" class="btn btn-danger btn-link btn-sm">
									<i class="material-icons">delete</i>
									Excluir
								</a>
								<a href="{URLEDITAR}" rel="tooltip" title="Editar" class="btn btn-info btn-link btn-sm" style="{BUTTONR}">
									<i class="material-icons">build</i>
									Editar
								</a>
							</td>
						</tr>
						{/BLC_DADOS}
						{BLC_SEMDADOS}
						<tr>
							<td colspan="4" class="text-center">Nenhum registro encontrado</td>
						</tr>
						{/BLC_SEMDADOS}
						</tbody>
						<tfoot>
						<tr>
							<th>#
							</th>
							<th>Nome
							</th>
							<th>Status
							</th>
							<th>Editar / Excluir
							</th>
						</tr>
						</tfoot>
					</table
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Fechar Conta</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="FormFecharVendas" action="" method="post">
					<input type="hidden" name="id" id="idcompanda" value="">
					<input type="hidden" name="cliente_id" id="idcliente" value="">
					<input type="hidden" name="users_id" id="idusuario" value="">
					<input type="hidden" name="valorfinal" id="valorfinal" value="">
					<div class="row">
						<div class="col-md-12">
							<h4>Usuário: <span class="nameusuario"></span></h4>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-6">
							<div class="control-group">
								<label class="bmd-label-floating" for="">Cliente: </label>
								<span class="namecliente"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="control-group">
								<label class="bmd-label-floating" for="">Barbeiro: </label>
								<span class="namebarbeiro"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="control-group">
								<div class="md-form">
									<label for="date-picker-example">Data:</label>
									<span class="data"></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="control-group">
								<div class="md-form">
									<label for="precofinal">Valor:</label>
									<span class="valor"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<!--Basic textarea-->
							<div class="md-form">
								<label for="textareaBasic">Observação</label>
								<span class="observacao"></span>
							</div>
						</div>
						<div class="col-md-12">
							<!--Basic textarea-->
							<div class="md-form">
								<label for="textareaBasic">Forma de Pagamento:</label>
								<select class="form-control" name="formapagamento" id="formaPagamentoSelect">
									<option value="cartaocredito">Cartão de Crédito</option>
									<option value="cartaodebito">Cartão de Debito</option>
									<option value="dinheiro">Dinheiro</option>
									<option value="gratis">Grátis</option>
								</select>
							</div>
							<br>
							<div class="md-form" id="mostra">
								<div class="areatroco">
									<label for="textareaBasic">Valor em dinheiro:</label>
									<input type="text" name="troco" id="precofinal" class="form-control troco" value="">
									<button type="button" id="buttonCalcTroco" class="btn pull-right">CALCULAR TROCO</button>
								</div>
								<div class="col-md-12">
									<h2 id="valorTroco"></h2>
								</div>	
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="button" id="SalvarFecharConta" class="btn btn-primary">Salvar</button>
			</div>
		</div>
	</div>
</div>

