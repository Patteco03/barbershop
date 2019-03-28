<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de produtos</p>
				</div>
				<div class="card-body">
					<form action="{ACAOFORM}" method="post">
						<input type="hidden" name="id" id="id"
							   value="{id}">

						<div class="row">
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">Categoria: </label>
									<select name="category" class="form-control" id="category">
										{BLC_CATEGORY}
										<option value="{category_id}" {sel_cat}> {nome}</option>
										{/BLC_CATEGORY}
									</select>
								</div>
							</div>

							<div class="col-md-5">
								<div class="control-group">
									<label class="bmd-label-floating" for="nome">Nome: </label>
									<input type="text" name="name" class="form-control" id="nome" value="{nome}" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="control-group">
									<label class="bmd-label-floating" for="username">Preço: </label>
									<input type="text" class="form-control" name="preco" id="preco"
										   value="{preco}"
										   required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<!--Basic textarea-->
								<div class="md-form">
									<textarea type="text" id="textareaBasic" class="form-control md-textarea" rows="3" name="observacao">{observacao}</textarea>
									<label for="textareaBasic">Observação</label>
								</div>
							</div>
						</div>


						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/product"
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
