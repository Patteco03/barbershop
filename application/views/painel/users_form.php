<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">{ACAO}</h4>
					<p class="card-category">Formulário de cadastro de usuários</p>
				</div>
				<div class="card-body">
					<form action="{ACAOFORM}" method="post">
						<input type="hidden" name="idusuario" id="idusuario"
							   value="{id}">

						<div class="row">
							<div class="col-md-3">
								<div class="control-group">
									<label class="bmd-label-floating" for="">Cargo: </label>
									<select name="roles_id" class="form-control" id="roles_id">
										{BLC_CARGO}
										<option value="{roles_id}" {sel_cargo}> {nome}</option>
										{/BLC_CARGO}
									</select>
								</div>
							</div>

							<div class="col-md-5">
								<div class="control-group">
									<label class="bmd-label-floating" for="nome">Nome: </label>
									<input type="text" name="name" class="form-control" id="nome" value="{name}" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="control-group">
									<label class="bmd-label-floating" for="username">Usuário: </label>
									<input type="text" class="form-control" name="username" id="username"
										   value="{username}"
										   required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="control-group">
									<label class="bmd-label-floating" for="email">E-mail: </label>
									<input type="text" class="form-control" name="email" id="email" value="{email}"
										   required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="control-group">
									<label class="bmd-label-floating" for="senha">Senha: </label>
									<input type="password" class="form-control" name="password" id="password" value=""
										   required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="control-group">
									<label class="control-label" for="email">Status: </label>
									<div class="controls">
										<input type="radio" class="span3" name="status" id="status" {chk_1} value="1"> Ativo
										<input type="radio" class="span3" name="status" id="status" {chk_0} value="0"> Inativo
									</div> <!-- /controls -->
								</div> <!-- /control-group -->
							</div>
						</div>

						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-success"><i
									class="material-icons">save</i> Adicionar
							</button>
							<a href="<?php echo base_url() ?>painel/users"
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
