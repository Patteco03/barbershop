<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-tabs card-header-primary">
					<div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="nav-item">
									<a class="nav-link active" href="#produto" data-toggle="tab">
										Produto
										<div class="ripple-container"></div>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#categoria" data-toggle="tab">
										Categoria
										<div class="ripple-container"></div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="produto">
							<a href="{URLADICIONAR}" title="Adicionar">
								<button type="button" class="btn btn-success"><i class="material-icons">add</i> Adicionar
								</button>
							</a>
							<table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th class="th-sm">#
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Nome
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Valor Unitário
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Categoria
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Qtd Estoque
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Exlcuir / Editar
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
								</tr>
								</thead>
								<tbody>
								{BLC_DADOS}
								<tr>
									<td>{ID}</td>
									<td>{NOME}</td>
									<td>R$ {PRECO}</td>
									<td>{CATEGORY}</td>
									<td>
										{QTDESTOQUE}
										<a href="{ESTOQUE}" id="estoque" title="Estoque" rel="tooltip" class="btn btn-danger btn-link btn-sm">
											Alterar
										</a>
									</td>
									<td>
										<a href="{URLEXCLUIR}" id="delete" title="Excluir" rel="tooltip" class="btn btn-danger btn-link btn-sm">
											<i class="material-icons">delete</i>
											Excluir
										</a>
										<a href="{URLEDITAR}" rel="tooltip" title="Editar" class="btn btn-info btn-link btn-sm">
											<i class="material-icons">build</i>
											Editar
										</a>
									</td>
								</tr>
								{/BLC_DADOS}
								{BLC_SEMDADOS}
								<tr>
									<td colspan="5" class="text-center">Nenhum registro encontrado</td>
								</tr>
								{/BLC_SEMDADOS}
								</tbody>
								<tfoot>
								<tr>
									<th>#
									</th>
									<th>Nome
									</th>
									<th>Preço
									</th>
									<th>Categoria
									</th>
									<th>Excluir / Editar</th>
								</tr>
								</tfoot>
							</table>
						</div>
						<div class="tab-pane" id="categoria">
							<a href="{URLADICIONARCATEGORY}" title="Adicionar">
								<button type="button" class="btn btn-success"><i class="material-icons">add</i> Adicionar
								</button>
							</a>
							<table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th class="th-sm">#
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Nome
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Exlcuir / Editar
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
								</tr>
								</thead>
								<tbody>
								{BLC_CATEGORY}
								<tr>
									<td>{ID}</td>
									<td>{NOME}</td>
									<td>
										<a href="{URLEXCLUIR}" id="delete" title="Excluir" rel="tooltip" class="btn btn-danger btn-link btn-sm">
											<i class="material-icons">delete</i>
											Excluir
										</a>
										<a href="{URLEDITAR}" rel="tooltip" title="Editar" class="btn btn-info btn-link btn-sm">
											<i class="material-icons">build</i>
											Editar
										</a>
									</td>
								</tr>
								{/BLC_CATEGORY}
								{BLCSEM_CATEGORY}
								<tr>
									<td colspan="3" class="text-center">Nenhum registro encontrado</td>
								</tr>
								{/BLCSEM_CATEGORY}
								</tbody>
								<tfoot>
								<tr>
									<th>#
									</th>
									<th>Nome
									</th>
									<th>Excluir / Editar
									</th>
								</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


