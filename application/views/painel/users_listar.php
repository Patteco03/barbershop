<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title ">Clientes</h4>
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
							<th class="th-sm">Username
								<i class="material-icons" aria-hidden="true">import_export</i>
							</th>
							<th class="th-sm">E-mail
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
							<td>{USERNAME}</td>
							<td>{EMAIL}</td>
							<td>{STATUS}</td>
							<td>
								<a href="{URLEXCLUIR}" id="delete" title="Excluir" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-id="{IDTURMA}">
									<i class="material-icons">delete</i>
									Excluir
								</a>
								<a href="{URLEDITAR}" rel="tooltip" title="Editar" class="btn  btn-info btn-link btn-sm">
									<i class="material-icons">build</i>
									Editar
								</a>
							</td>
						</tr>
						{/BLC_DADOS}
						{BLC_SEMDADOS}
						<tr>
							<td colspan="3" class="text-center">Nenhum registro encontrado</td>
						</tr>
						{/BLC_SEMDADOS}
						</tbody>
						<tfoot>
						<tr>
							<th>#
							</th>
							<th>Nome
							</th>
							<th>Username
							</th>
							<th>E-mail
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


