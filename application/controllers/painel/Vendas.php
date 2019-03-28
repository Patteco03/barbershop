<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Vendas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Vendas_Model', 'VendasM');
		$this->load->model('Cliente_Model', 'ClienteM');
		$this->load->model('Barber_Model', 'BarberM');
		$this->load->model('Product_Model', 'ProdutoM');
		$this->load->model('Service_Model', 'ServiceM');
		$this->load->model('ComandaProduto_Model', 'ComanpM');
		$this->load->model('ComandaService_Model', 'ComansM');
		$this->load->model('Estoque_Model', 'EstoqueM');
	}

	public function index()
	{
		$data = array();
		$data['URLLISTAR'] = site_url('painel/vendas');
		$data['URLADICIONAR'] = site_url('painel/vendas/adicionar');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();


		$res = $this->VendasM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {
				if ($r->status == '1') {
					
				}

				$cliente = $this->ClienteM->get(array("id" => $r->cliente_id), FALSE, FALSE);
				$nome = null;
				foreach ($cliente as $c) {
					$nome = $c->nome;
				}
				$this->load->model('Cupom_Model', 'CupomM');
				$cupom = $this->CupomM->get(array("cliente_id" => $r->cliente_id), FAlSE, FAlSE);
				$quantidade = null;
				if ($cupom) {
					foreach ($cupom as $cpm) {
						if ($cpm->quantidade == 10) {
							$quantidade = '<i class="material-icons" style="color:#FF5C00;">star</i>';
						}
					}
				}else{
					$quantidade = null;
				}
				

				$data['BLC_DADOS'][] = array(
					"ID" => $r->id,
					"NOME" => $nome,
					"CUPOM" => $quantidade, 
					"BUTTONR" => ($r->status == '1')? 'display:none;': '',
					"STATUS" => ($r->status == '1') ? '<button class="btn btn-success">Finalizado</button>' : '<button id="fecharConta" data-id="' . $r->id . '" class="btn btn-danger" data-toggle="modal" data-target="#basicExampleModal">Fechar Conta</button>',
					"URLEDITAR" => site_url('painel/vendas/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/vendas/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}


		$this->parser->parse('painel/vendas_listar', $data);
	}

	public function adicionar()
	{

		$usuario = $this->session->userdata('loginusers');

		$data = array();
		$data['ACAO'] = 'Nova venda';
		$data['ACAOFORM'] = site_url('painel/vendas/salvar');
		$data['id'] = null;
		$data['usuario'] = $usuario['username'];
		$data['users_id'] = $usuario['users_id'];
		$data['observacao'] = null;
		$data['precofinal'] = null;

		$data['BLC_CLIENTE'] = array();
		$data['BLC_BARBEIRO'] = array();
		$data['BLC_PRODUTOS'] = array();
		$data['BLC_SERVICO'] = array();
		$data['LIST_PRO'] = array();
		$data['LIST_SER'] = array();


		$cliente = $this->ClienteM->get(array(), FALSE, FALSE);
		if ($cliente) {
			foreach ($cliente as $c) {
				$data['BLC_CLIENTE'][] = array(
					"cliente_id" => $c->id,
					"nome" => $c->nome,
					"sel_cliente" => null
				);
			}
		}

		$barber = $this->BarberM->get(array(), FALSE, FALSE);
		if ($barber) {
			foreach ($barber as $b) {
				$data['BLC_BARBEIRO'][] = array(
					"barber_id" => $b->id,
					"nome" => $b->nome,
					"sel_barber" => null
				);
			}
		}

		$produtos = $this->ProdutoM->get(array(), FALSE, FALSE);
		if ($produtos) {
			$listprodutos = array();
			foreach ($produtos as $p) {
				$listprodutos[] = array(
					"product_id" => $p->id,
					"nome" => $p->nome,
					"preco" => $p->preco,
					"sel_produto" => null
				);
			}

			$data['BLC_PRODUTOS'][] = array(
				"LIST_PRODUTOS" => $listprodutos
			);
		}

		$service = $this->ServiceM->get(array(), FALSE, FALSE);
		if ($service) {
			$listservice = array();
			foreach ($service as $s) {
				$listservice[] = array(
					"service_id" => $s->id,
					"nome" => $s->nome,
					"preco" => $s->preco,
					"sel_servico" => null
				);
			}

			$data['BLC_SERVICO'][] = array(
				"LIST_SERVICO" => $listservice
			);
		}


		$this->parser->parse('painel/vendas_form', $data);
	}

	public function editar($id)
	{
		$data = array();
		$usuario = $this->session->userdata('loginusers');
		$data['ACAO'] = 'Edição';
		$data['usuario'] = $usuario['username'];
		$data['users_id'] = $usuario['users_id'];
		$data['ACAOFORM'] = site_url('painel/vendas/salvar');

		$res = $this->VendasM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$data['BLC_CLIENTE'] = array();
		$data['BLC_BARBEIRO'] = array();
		$data['BLC_PRODUTOS'] = array();
		$data['BLC_SERVICO'] = array();
		$data['LIST_PRO'] = array();
		$data['LIST_SER'] = array();

		$cliente = $this->ClienteM->get(array(), FALSE, FALSE);
		if ($cliente) {
			foreach ($cliente as $c) {
				$data['BLC_CLIENTE'][] = array(
					"cliente_id" => $c->id,
					"nome" => $c->nome,
					"sel_cliente" => ($res->cliente_id == $c->id) ? 'selected="selected"' : null
				);
			}
		}

		$barber = $this->BarberM->get(array(), FALSE, FALSE);
		if ($barber) {
			foreach ($barber as $b) {

				$comandaService = $this->ComansM->get(array("comanda_id" => $id), FALSE, FALSE);
				$barbeiroSell = null;
				foreach ($comandaService as $co) {
					$barbeiroSell = ($co->barber_id == $b->id) ? 'selected="selected"' : null;
				}

				$data['BLC_BARBEIRO'][] = array(
					"barber_id" => $b->id,
					"nome" => $b->nome,
					"sel_barber" => $barbeiroSell
				);
			}
		}

		$contadorP = 0;
		$comandaProduto = $this->ComanpM->get(array("comanda_id" => $id), FAlSE, FALSE);
		if ($comandaProduto) {
			foreach ($comandaProduto as $cp) {
				$llproduto = $this->ProdutoM->get(array("id" => $cp->product_id), FALSE, FALSE);
				foreach ($llproduto as $p) {
					$data['LIST_PRO'][] = array(
						"id" => $p->id,
						"preco" => $p->preco,
						"nome" => $p->nome,
						"contador" => 'produChild'. $contadorP++
					);
				}
			}
		}

		$contadorS = 0;
		$cpService = $this->ComansM->get(array("comanda_id" => $id), FAlSE, FALSE);
		if ($cpService) {
			foreach ($cpService as $cp) {
				$llproduto = $this->ServiceM->get(array("id" => $cp->service_id), FALSE, FALSE);
				foreach ($llproduto as $p) {
					$data['LIST_SER'][] = array(
						"id" => $p->id,
						"preco" => $p->preco,
						"nome" => $p->nome,
						"contador" => 'serviceChild'. $contadorS++
					);
				}
			}
		}

		$produtos = $this->ProdutoM->get(array(), FALSE, FALSE);
		if ($produtos) {
			$listprodutos = array();
			foreach ($produtos as $p) {


				$listprodutos[] = array(
					"product_id" => $p->id,
					"nome" => $p->nome,
					"preco" => $p->preco,
					"sel_produto" => null
				);
			}

			$data['BLC_PRODUTOS'][] = array(
				"LIST_PRODUTOS" => $listprodutos
			);
		}

		$service = $this->ServiceM->get(array(), FALSE, FALSE);
		if ($service) {
			$listservice = array();
			foreach ($service as $s) {
				$listservice[] = array(
					"service_id" => $s->id,
					"nome" => $s->nome,
					"preco" => $s->preco,
					"sel_servico" => null
				);
			}

			$data['BLC_SERVICO'][] = array(
				"LIST_SERVICO" => $listservice
			);
		}


		$this->parser->parse('painel/vendas_form', $data);
	}

	public function salvar()
	{

		$id = $this->input->post('id');
		$users = $this->input->post('users_id');
		$cliente = $this->input->post('cliente');
		$barber = $this->input->post('barber');
		$produto = $this->input->post('produto');
		$service = $this->input->post('servico');
		$data = $this->input->post('data');
		$status = 0;
		$caixa = 1;
		$precofinal = $this->input->post('precofinal');
		$observacao = $this->input->post('observacao');

		$erros = FALSE;
		$mensagem = null;

		if (!$data) {
			$erros = TRUE;
			$mensagem .= "Informe a data\n";
		}

		if ($service) {
			if (!$barber) {
				$erros = TRUE;
				$mensagem .= "Há um serviço disponível selecione o barbeiro\n";
			}
		}
		if ($barber) {
			if (!$service) {
				$erros = TRUE;
				$mensagem .= "Barbeiro selecionado, defina um serviço\n";
			}
		}

		$countProduto = 0;
		$msgEstoque = null;
		$calcProdutoEstoque = 0;
		if (!$id){
			if ($produto) {
				foreach ($produto as $listProduto) {
					$countProduto++;

					$searchEstoque = $this->EstoqueM->get(array("product_id" => $listProduto), FALSE, FALSE);

					if ($searchEstoque) {
						foreach ($searchEstoque as $s) {
							$qtdProdutoEstoque = $s->quantidade;

							$calcProdutoEstoque = $qtdProdutoEstoque - $countProduto;

							if ($calcProdutoEstoque < 0) {
								$erros = TRUE;
								$msgEstoque = "Produto em estoque insuficiente\n";
							}
						}
					} else {
						$erros = TRUE;
						$mensagem .= "Sem Produto em estoque\n";
					}
				}
				$mensagem .= $msgEstoque;
			}else{

			}
		}



		if (!$erros) {
			$itens = array(
				"id" => $id,
				"users_id" => $users,
				"cliente_id" => $cliente,
				"data" => $data,
				"status" => $status,
				"precofinal" => $precofinal,
				"observacao" => $observacao,
				"caixa_id" => $caixa
			);


			if ($id) {
				$this->ComanpM->delete($id);
				$this->ComansM->delete($id);
				$id = $this->VendasM->update($itens, $id);

				if ($produto) {
					foreach ($produto as $p) {
						$itenProd = array(
							"comanda_id" => $id,
							"product_id" => $p
						);

						$this->ComanpM->post($itenProd);

						$searchEstoque = $this->EstoqueM->get(array("product_id" => $p), FALSE, FALSE);
						foreach ($searchEstoque as $s){
							$itenEstoque = array(
								"quantidade" => $calcProdutoEstoque,
								"product_id" => $p
							);

							$this->EstoqueM->update($itenEstoque, $s->id);
						}
					}
				}

				if ($service) {

					foreach ($service as $s) {
						$itenServ = array(
							"comanda_id" => $id,
							"barber_id" => $barber,
							"service_id" => $s
						);
						$this->ComansM->post($itenServ);
					}
				}

			} else {
				$id = $this->VendasM->post($itens);

				if ($produto) {
					foreach ($produto as $p) {
						$itenProd = array(
							"comanda_id" => $id,
							"product_id" => $p
						);
						$this->ComanpM->post($itenProd);

						$searchEstoque = $this->EstoqueM->get(array("product_id" => $p), FALSE, FALSE);
						foreach ($searchEstoque as $s){
							$itenEstoque = array(
								"quantidade" => $calcProdutoEstoque,
								"product_id" => $p
							);

							$this->EstoqueM->update($itenEstoque, $s->id);
						}
					}
				}

				if ($service) {
					foreach ($service as $s) {
						$itenServ = array(
							"comanda_id" => $id,
							"barber_id" => $barber,
							"service_id" => $s
						);
						$this->ComansM->post($itenServ);
					}
				}

			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/vendas');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($id) {
					redirect('painel/vendas/editar/' . $id);
				} else {
					redirect('painel/vendas/adicionar');
				}
			}


		} else {
			$this->session->set_flashdata('error', nl2br($mensagem));
			if ($id) {
				redirect('painel/vendas/editar/' . $id);
			} else {
				redirect('painel/vendas/adicionar');
			}
		}

	}

	public function fecharConta()
	{

		$id = $this->input->post('id');

		$data = array();
		$usuario = $this->session->userdata('loginusers');
		$data['usuario'] = $usuario['username'];
		$data['users_id'] = $usuario['users_id'];

		$res = $this->VendasM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		if ($res->data) {
			$datamensagem = date("d/m/Y", strtotime($res->data));
			$data['datamensagem'] = $datamensagem;
		}


		$cliente = $this->ClienteM->get(array("id" => $res->cliente_id), FALSE, FALSE);
		foreach ($cliente as $c) {
			$data['nomecliente'] = $c->nome;
		}


		$comandaService = $this->ComansM->get(array("comanda_id" => $id), FALSE, FALSE);
		foreach ($comandaService as $co) {
			$barber = $this->BarberM->get(array("id" => $co->barber_id), FALSE, FALSE);
			foreach ($barber as $item) {
				$data['namebarbeiro'] = $item->nome;
			}
		}


		$comandaProduto = $this->ComanpM->get(array("comanda_id" => $id), FAlSE, FALSE);
		if ($comandaProduto) {
			foreach ($comandaProduto as $cp) {
				$llproduto = $this->ProdutoM->get(array("id" => $cp->product_id), FALSE, FALSE);
				foreach ($llproduto as $p) {
					$data['LIST_PRO'][] = array(
						"id" => $p->id,
						"preco" => $p->preco,
						"nome" => $p->nome
					);
				}
			}
		}
		$cpService = $this->ComansM->get(array("comanda_id" => $id), FAlSE, FALSE);
		if ($cpService) {
			foreach ($cpService as $cp) {
				$llproduto = $this->ServiceM->get(array("id" => $cp->service_id), FALSE, FALSE);
				foreach ($llproduto as $p) {
					$data['LIST_SER'][] = array(
						"id" => $p->id,
						"preco" => $p->preco,
						"nome" => $p->nome
					);
				}
			}
		}


		$retorno = array(
			'data' => $data
		);
		echo json_encode($retorno);
		die();
	}

	public function updateSalvarVendas()
	{
		$id = $this->input->post('id');
		$valorfinal = $this->input->post('valorfinal');
		$formapagamento = $this->input->post('formapagamento');
		$idCaixa = 1;

		$this->load->model('Caixa_Model', 'CaixaM');
		$caixa = $this->CaixaM->get(array("id" => $idCaixa), FAlSE, FALSE);
		$saldoCaixa = 0;
		$somaCaixa = 0;
		if ($caixa){
			foreach ($caixa as $item) {
				$saldoCaixa = $item->saldo;
			}
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$itens = array(
			"status" => 1,
			"formapagamento" => $formapagamento
		);

		$somaCaixa = $saldoCaixa += $valorfinal;

		if ($id) {
			$id = $this->VendasM->update($itens, $id);
		} else {
			$id = $this->VendasM->post($itens, $id);
		}

		if ($id) {
			$retorno = array(
				'codigo' => 0,
				'mensagem' => 'Vendas Finalizada com sucesso!'
			);

			$this->load->model('Cupom_Model', 'CupomM');
			$res = $this->VendasM->get(array("id" => $id), FALSE, FALSE);
			foreach ($res as $r) {
				$cupom = $this->CupomM->get(array("cliente_id" => $r->cliente_id), FALSE, FAlSE);
				$somaQuantidade = 0;
				$idcupom = null;
				if ($cupom) {
					foreach ($cupom as $c) {
						$somaQuantidade = $c->quantidade + 1;
						$idcupom = $c->id;

						if ($c->quantidade == 10) {
							$somaQuantidade = 0;
						}
					}

					if ($valorfinal >= 30) {
						$arrayCupom = array(
							"cliente_id" => $r->cliente_id,
							"cod" => substr(md5(time()), 0, 6),
							"quantidade" => $somaQuantidade
						);
					}

					$this->CupomM->update($arrayCupom, $idcupom);
				}else{
					if ($valorfinal >= 30) {
						$arrayCupom = array(
							"cliente_id" => $r->cliente_id,
							"cod" => substr(md5(time()), 0, 6),
							"quantidade" => 1
						);
					}
					$this->CupomM->post($arrayCupom);
				}


			}
			


			$itenUpdateSaldo = array(
				"saldo" => $somaCaixa
			);

			$this->CaixaM->update($itenUpdateSaldo, $idCaixa);

			$this->load->model('Movimentacao_Model', 'MoviM');
			$movimentacao = array(
				"data" => date('Y-m-d'),
				"time" => date('H:i:s'), 
				"descricao"=> 'venda',
				"comanda_id" => $id
			);
			$this->MoviM->post($movimentacao);

			echo json_encode($retorno);
			die();
		} else {
			$retorno = array(
				'codigo' => 0,
				'mensagem' => 'Ocorreu um erro ao realizar operação!'
			);
			echo json_encode($retorno);
			die();
		}

	}

	public function excluir($id)
	{	
		$this->load->model('Caixa_Model', 'CaixaM');
		$valor = 0.00;
		$valorRetorno = 0.00;
		$caixa_id = 1;
		$vendas = $this->VendasM->get(array("id" => $id), FALSE, FALSE);
		if ($vendas) {
			foreach ($vendas as $r) {
				$valor = $r->precofinal;
			}
		}
		$caixa = $this->CaixaM->get(array(), FALSE, FALSE);
		if ($caixa) {
			foreach ($caixa as $r) {
				$valorRetorno = $r->saldo - $valor;
			}
		}
		$valorupdate = array(
			"id" => $caixa_id,
			"saldo" => $valorRetorno
		);
		$this->CaixaM->update($valorupdate, $caixa_id);

		$res = $this->VendasM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Venda removida com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Venda não pode ser removida.');
		}

		redirect('painel/vendas');
	}


}
