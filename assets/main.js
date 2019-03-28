$(document).ready(function () {

	$('#telefone').mask('(68)99999-9999');
	$('#money').mask('000.000.000.000.000,00', {reverse: true});
	$('#precofinal').mask('000.000.000.000.000,00', {reverse: true});
	$('#preco').mask('000.000.000.000.000,00', {reverse: true});
	$('#cep').mask('99999-999');
	$('#porcentagem').mask('999');


	var urlBase = $('#siteURL').val();
	urlBase = urlBase.replace(/\s/g, '');

	$('#dtBasicExample').DataTable({
		"order": [[0, "desc" ]]
	});
	$('.dataTables_length').addClass('bs-select');

	$("#ListProdutos").change(function () {
		var id = $('select[name=produto]').val();

		$.ajax({
			type: 'POST',
			url: urlBase + "painel/product/getProdutos",
			data: {id},
			dataType: "json",
			success: function (json) {
				$.each(json, function (key, value) {
					$("#PrecoProdutos").val(value.preco);
					$("#observacaoProdutos").val(value.observacao);
					$("#CatProdutos").val(value.category);
				});
			},
			error: function () {

			}
		});
	});

	$("#ListServico").change(function () {
		var id = $('select[name=servico]').val();

		$.ajax({
			type: 'POST',
			url: urlBase + "painel/service/getService",
			data: {id},
			dataType: "json",
			success: function (json) {
				$.each(json, function (key, value) {
					$("#PrecoServico").val(value.preco);
				});
			},
			error: function () {

			}
		});
	});

	$('#btnAddProduto').on('click', function () {
		var id = $('select[name=produto]').val();
		var nome = $('#ListProdutos option:selected').attr("name");
		var preco = $('#PrecoProdutos').val();


		if (!id) {
			alert('Selecione um produto');
		} else {
			var el = '<li class="formListItens" id="formListItens"><label class="bmd-label-floating">Produto</label>\n' +
			'<input type="hidden" name="produto[]" class="form-control input" pr="' + preco + '" value="' + id + '"> ' + nome + "\tR$" + preco +
			'</li>';
			$('#content-prList').append(el);
		}

	});


	$('#btnAddServico').on('click', function () {
		var id = $('select[name=servico]').val();
		var nome = $('#ListServico option:selected').attr("name");
		var preco = $('#PrecoServico').val();

		if (!id) {
			alert('Selecione um Serviço');
		} else {
			var el = '<li class="formListItens" id="formListItens"><label class="bmd-label-floating">Serviço</label>\n' +
			'<input type="hidden" name="servico[]" class="form-control input" pr="' + preco + '" value="' + id + '"> ' + nome + "\tR$" + preco + ' </li>';
			$('#content-prList').append(el);
		}

	});


	$("#btnAddProduto, #btnAddServico, .remove").click(function () {
		var total = 0;
		$('.input').each(function () {
			var valor = Number($(this).attr("pr"));
			if (!isNaN(valor)) total += valor;
		});
		$("#precofinal").val(total.toFixed(2));
	});


	$("#SubmitForm").click(function () {
		$("#FormVendas").submit();
	});


	function fecharConta(id) {
		$.ajax({
			url: urlBase + "painel/vendas/fecharConta",
			type: 'post',
			dataType: 'json',
			data: {
				id: id
			},
			success: function (response) {
				$.each(response, function (index, value) {
					$('#idcompanda').val(id);
					$('#idcliente').val(value.cliente_id);
					$('#idusuario').val(value.users_id);
					$('#valorfinal').val(value.precofinal);
					$('.nameusuario').html(value.usuario);
					$('.namecliente').html(value.nomecliente);
					$('.namebarbeiro').html(value.namebarbeiro);
					$('.data').html(value.datamensagem);
					$('.valor').html(value.precofinal);
					$('.observacao').html(value.observacao);


					$('#formaPagamentoSelect').change(function(){
						var valor = $('#formaPagamentoSelect').val();
						if (valor == 'dinheiro') {
							$('#mostra').css('display','block')

							$('#buttonCalcTroco').click(function(){
								var entrada = parseFloat($('.troco').val());
								if (entrada) {
									var saldo = parseFloat(value.precofinal);
									var calc = entrada - saldo;
									$('#valorTroco').html('R$ ' + calc.toFixed(2).replace('.',','));
								}else{
									alert('Informe um valor');
								}

							});

						}else{
							$('#mostra').css('display','none')
						}
					});
				});
			},
			error: function () {

			}
		})
		return false;
	}

	$(document).on('click', '#fecharConta', function () {
		var id = $(this).data('id');
		fecharConta(id);
	});

	$("#SalvarFecharConta").click(function () {
		var id = $("#FormFecharVendas").serialize();

		$.ajax({
			type: 'POST',
			url: urlBase + 'painel/vendas/updateSalvarVendas',
			data: id,
			dataType: 'json',
			beforeSend: function () {
				$("#SalvarFecharConta").prop("disabled", true);
				$("#SalvarFecharConta").html('salvando ...');
			},
			success: function (response) {
				$.each(response, function (index, value) {
					if (response.codigo == 1) {
						$("#SalvarFecharConta").prop("disabled", false);
						$("#SalvarFecharConta").html('salvar');
					} else {
						$("#SalvarFecharConta").html('salvar');
						$("#SalvarFecharConta").prop("disabled", false);
						$("#FormFecharVendas").fadeOut('slow', function () {
							location.reload(true);
							$("#FormFecharVendas").fadeIn(10000);
						});
					}
				});
			},
			error: function () {
				$(".Exiberro").html('<strong> Ocorreu um  Erro! </strong>');
			}
		});

	});


	function limpa_formulário_cep() {
		// Limpa valores do formulário de cep.
		$("#rua").val("");
		$("#bairro").val("");
		$("#cidade").val("");
		$("#uf").val("");
		$("#ibge").val("");
	}

	//Quando o campo cep perde o foco.
	$("#cep").blur(function () {

		//Nova variável "cep" somente com dígitos.
		var cep = $(this).val().replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if (validacep.test(cep)) {

				//Preenche os campos com "..." enquanto consulta webservice.
				$("#rua").val("...");
				$("#bairro").val("...");
				$("#cidade").val("...");
				$("#uf").val("...");
				$("#ibge").val("...");

				//Consulta o webservice viacep.com.br/
				$.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

					if (!("erro" in dados)) {
						//Atualiza os campos com os valores da consulta.
						$("#rua").val(dados.logradouro);
						$("#bairro").val(dados.bairro);
						$("#cidade").val(dados.localidade);
						$("#uf").val(dados.uf);
						$("#ibge").val(dados.ibge);
					} //end if.
					else {
						//CEP pesquisado não foi encontrado.
						limpa_formulário_cep();
						alertify.alert("CEP não encontrado");
					}
				});
			} //end if.
			else {
				//cep é inválido.
				limpa_formulário_cep();
				// alert dialog
				alertify.alert("Formato de CEP Inválido");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulário_cep();
		}
	});

	$("#RegistrarCaixa").click(function () {
		$("#formRegistrarCaixa").submit();
	});

	$('a#delete').confirm({
		title: "Ops!",
		content: "Tem certeza que deseja excluir?",
	});
	$('a#delete').confirm({
		buttons: {
			hey: function () {
				location.href = this.$target.attr('href');
			}
		}
	});


	$('.js-example-basic-single').select2();


	/*MODAL ABERTURA DE CAIXA */
	$.ajax({
		type: 'GET',
		url: urlBase + 'painel/dashboard/statusCaixa',
		dataType: 'json',
		contentType: 'application/json',
		crossDomain: true,
		cache: false,
		success: function (response) {
			$.each(response, function (index, value) {
				if (value.status == 0) {
					$('#ModalCaixa').modal({
						backdrop: 'static',
						keyboard: false,
						show: true
					});
				} else {
					$('#ModalCaixa').modal('hide');
				}
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Erro ao carregar');
			console.log(errorThrown);
		}
	});

	$("#aberturaCaixa").click(function () {
		var id = $("#FormAberturaCaixa").serialize();

		$.ajax({
			type: 'POST',
			url: urlBase + 'painel/dashboard/aberturaCaixa',
			data: id,
			dataType: 'json',
			beforeSend: function () {
				$("#aberturaCaixa").prop("disabled", true);
				$("#aberturaCaixa").html('Atualizando ...');
			},
			success: function (response) {
				$.each(response, function (index, value) {
					if (response.codigo == 1) {
						$("#aberturaCaixa").prop("disabled", false);
						$("#aberturaCaixa").html('Atualizar');
					} else {
						$("#aberturaCaixa").html('Atualizar');
						$("#aberturaCaixa").prop("disabled", false);
						$("#FormAberturaCaixa").fadeOut('slow', function () {
							location.reload(true);
							$("#FormAberturaCaixa").fadeIn(10000);
						});
					}
				});
			},
			error: function () {
				$(".Exiberro").html('<strong> Ocorreu um  Erro! </strong>');
			}
		});

	});

	$("#remove" ).click(function() {
		var pai = $("#content-prList");

		var valor = ($(this).attr("remove-id"));
		$(valor).remove();
	});


	$("#consultarHistorico").on("click", function() {
		var data = $("#dataConsulta").val();

		$.ajax({
			type: 'POST',
			url: urlBase + 'painel/historicocaixa/getResults',
			data: {data},
			dataType: 'json',
			beforeSend: function () {
				$("#consultarHistorico").prop("disabled", true);
				$("#consultarHistorico").html('Pesquisando ...');
			},
			success: function (response) {
				$.each(response, function (index, value) {
					$("#consultarHistorico").prop("disabled", false);
					$("#consultarHistorico").html('Consultar');

					$(".valorvenda").html('total VENDAS: R$ ' + value.valortotalv.toFixed(2).replace('.',','));
					$(".valorsaida").html('total SAÍDA: R$ ' + value.valortotalpgt.toFixed(2).replace('.',','));
					$(".valorsaldo").html('saldo: R$ ' + value.saldo.toFixed(2).replace('.',','));

					var iconstatus = '';
					var colorbutton = '';
					var nomesaida = '';
					var valor = '';
					if (value.descricao == 'venda') {
						$.each(value.listcomandas, function(index, cont){
							valor = cont.valor;
						});
						iconstatus = 'trending_up';
						colorbutton = 'btn-success';
					}else{
						$.each(value.listpagamentos, function(index, cont){
							valor = cont.valor;
						});
						iconstatus = 'trending_down';
						colorbutton = 'btn-danger';
					}

					var element = '<li class="list-group-item listgrpi"><h4>'+value.descricao +' <i class="iconstatus material-icons '+colorbutton+'">'+iconstatus+'</i></h4>Data e hora: '+value.data+' '+ value.time+'<br>Valor: R$ '+valor+'</li>';
					$("#listHistorico").append(element);


				});
			},
			error: function () {
				$(".Exiberro").html('<strong> Ocorreu um  Erro! </strong>');
			}
		});

	});


});
