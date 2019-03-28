<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de serviços</p>
				</div>
				<div class="card-body">
					<form action="{ACAOFORM}" method="post">
						<input type="hidden" name="id" id="id"
							   value="{id}">

						<div class="row">
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
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">Comissão em serviços</label>
									<select name="comissao" class="form-control" id="comissao" required>
										{BLC_COMISSAO}
										<option value="{comissao_id}" {sel_com}> {nome} - R$ {por}</option>
										{/BLC_COMISSAO}
									</select>
								</div>
							</div>
						</div>

						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/service"
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
