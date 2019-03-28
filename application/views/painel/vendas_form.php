<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Vendas</p>
				</div>
				<div class="card-body">
					<form id="FormVendas" action="{ACAOFORM}" method="post">
						<input type="hidden" name="id" id="id" value="{id}">
						<input type="hidden" name="users_id" id="users_id" value="{users_id}">
						<div class="row">
							<div class="col-md-12">
								<span>Usuário: {usuario}</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">Cliente: </label>
									<select name="cliente" class="form-control js-example-basic-single" id="cliente" required>
										{BLC_CLIENTE}
										<option value="{cliente_id}" {sel_cliente}> {nome}</option>
										{/BLC_CLIENTE}
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">Barbeiro: </label>
									<select name="barber" class="form-control" id="barber">
										<option value="">Nenhum</option>
										{BLC_BARBEIRO}
										<option value="{barber_id}" {sel_barber}> {nome}</option>
										{/BLC_BARBEIRO}
									</select>
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
										<label for="precofinal">Valor:</label>
										<input type="text" name="precofinal" id="precofinal" class="form-control"
											   value="{precofinal}" required>
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
						<ul class="content-prList" id="content-prList">
							{LIST_PRO}
							<div class="form-group formListItens" id="{contador}">
								<label class="bmd-label-floating">Produto:</label>
								<input type="hidden" name="produto[]" class="form-control input" pr="{preco}"
									   value="{id}">
								<button type="button" id="remove" remove-id="{contador}" class="btn btn-danger float-right"><i
										class="material-icons">remove</i></button>
								{nome} R$ {preco}
							</div>
							{/LIST_PRO}
							{LIST_SER}
							<div class="form-group formListItens" id="{contador}">
								<label class="bmd-label-floating">Serviço:</label>
								<input type="hidden" name="servico[]" class="form-control input" pr="{preco}"
									   value="{id}">
								<button type="button" id="remove" remove-id="{contador}" class="btn btn-danger float-right"><i
										class="material-icons">remove</i></button>
								{nome} R$ {preco}
							</div>
							{/LIST_SER}
						</ul>
					</form>
					<br><br>
					<div class="row">
						<div class="col-md-12">
							<span>Adicionar Produto</span>
							<div class="clearfix"></div>
							<table class="table table-striped table-bordered" cellspacing="0"
								   width="100%">
								<tbody>
								{BLC_PRODUTOS}
								<tr>
									<td>
										Produto:
										<select name="produto" class="form-control" id="ListProdutos">
											<option value="">Nenhum</option>
											{LIST_PRODUTOS}
											<option value="{product_id}" name="{nome}" {sel_produto}> {nome}</option>
											{/LIST_PRODUTOS}
										</select>
									</td>
									<td>
										Preço:
										<div class="control-group">
											<input type="text" id="PrecoProdutos" class="form-control" value=""
												   disabled>
										</div>
									</td>
									<td>
										Categoria:
										<div class="control-group">
											<input type="text" id="CatProdutos" class="form-control" value=""
												   disabled>
										</div>
									</td>
									<td>
										Observacão:
										<div class="control-group">
											<input type="text" id="observacaoProdutos" class="form-control" value=""
												   disabled>
										</div>
									</td>
									<td>
										<button id="btnAddProduto" type="button" class="btn btn-success">add <i
												class="material-icons">add_shopping_cart</i>
										</button>
									</td>
								</tr>
								{/BLC_PRODUTOS}
								</tbody>
							</table
						</div>
					</div>
					<div class="col-md-12">
						<span>Adicionar Serviço</span>
						<div class="clearfix"></div>
						<table class="table table-striped table-bordered" cellspacing="0"
							   width="100%">
							<tbody>
							{BLC_SERVICO}
							<tr>
								<td>
									Produto:
									<select name="servico" class="form-control" id="ListServico">
										<option value="">Nenhum</option>
										{LIST_SERVICO}
										<option value="{service_id}" name="{nome}" {sel_servico}> {nome}</option>
										{/LIST_SERVICO}
									</select>
								</td>
								<td>
									Preço:
									<div class="control-group">
										<input type="text" id="PrecoServico" class="form-control" value="" disabled>
									</div>
								</td>
								<td>
									<button id="btnAddServico" type="button" class="btn btn-success">add <i
											class="material-icons">add_shopping_cart</i>
									</button>
								</td>
							</tr>
							{/BLC_SERVICO}
							</tbody>
						</table
					</div>
					<br><br>
					<div class="form-actions">
						<button type="button" id="SubmitForm" class="btn btn-success"><i
								class="material-icons">save</i> Adicionar
						</button>
						<a href="<?php echo site_url() ?>painel/vendas"
						   class="btn btn-danger"><i
								class="material-icons">reply</i> Voltar</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>