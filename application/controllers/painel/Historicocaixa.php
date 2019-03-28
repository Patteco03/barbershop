<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');

class historicocaixa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('HistoricoCaixa_Model', 'histoM');
	}

	public function index()
	{
		$data = array();
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['URLVOLTAR'] = site_url('painel/caixa');


		$res = $this->histoM->get(array(), FALSE, FALSE);
		$contador = 0;
		if ($res) {
			foreach ($res as $r) {

				$data['BLC_DADOS'][] = array(
					"DATACONSULTA" => $r->data,
					"DATA" => inverteData($r->data),
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}


		$this->parser->parse('painel/historicocaixa_listar', $data);
	}

	public function salvar()
	{

		$id = $this->input->post('id');
		$caixa_id = $this->input->post('caixa_id');
		$data = $this->input->post('data');
		$preco = $this->input->post('valor');

		$erros = FALSE;
		$mensagem = null;

		if (!$data) {
			$erros = TRUE;
			$mensagem .= "Informe a data.\n";
		} else {
			$total = $this->histoM->validaDataDuplicada($id, $data);
			if ($total > 0) {
				$erros = TRUE;
				$mensagem .= "Caixa já registrado impossivel salvar novamente.\n";
			}
		}


		if (!$erros) {
			$itens = array(
				"id" => $id,
				"data" => $data,
				"caixa_id" => $caixa_id,
				"valor" => $preco
			);


			if ($id) {
				$id = $this->histoM->update($itens, $id);
			} else {
				$id = $this->histoM->post($itens);
			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Caixa Fechado com sucesso.');
				$this->load->model('Caixa_Model', 'CaixaM');
				$valorupdate = array(
					"id" => $caixa_id,
					"saldo" => 0,
					"status" => 0
				);
				$this->CaixaM->update($valorupdate, $caixa_id);
				redirect('painel/caixa');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');
			}

		}else{
			$this->session->set_flashdata('error', nl2br($mensagem));
			redirect('painel/caixa/registrarcaixa/' . $caixa_id);
		}

	}

	public function getResults(){
		$data = $this->input->post('data');

		$this->load->model('Movimentacao_Model', 'MovM');
		$this->load->model('Pagamento_Model' , 'PagamentoM');
		$this->load->model('Vendas_Model', 'VendasM');
		$res = $this->MovM->get(array("data" => $data), FALSE, FALSE);
		$retorno = array();
		$listpagamentos = array();
		$listcomandas = array();
		$totalPagamentos = 0;
		$totalVendas = 0;
		$cont = 0;
		if ($res) {
			foreach ($res as $r) {
				if ($r->pagamento_id) {
					$pg    = $this->PagamentoM->get(array("id" => $r->pagamento_id), FALSE, FALSE);
						foreach($pg as $p) {
							$totalPagamentos = $totalPagamentos += $p->valor;
							$listpagamentos[] = array(
							"nome"   => $p->nome,
							"valor"  => $p->valor
						);
					}
				}
				if ($r->comanda_id) {
					$pg    = $this->VendasM->get(array("id" => $r->comanda_id), FALSE, FALSE);
						foreach($pg as $p) {
							$totalVendas = $totalVendas += $p->precofinal;
							$listcomandas[] = array(
							"valor"  => $p->precofinal
						);
					}
				}
				$saldo = $totalVendas - $totalPagamentos;
				$retorno [] = array(
					"id"       		=> $r->id,
					"descricao"     => $r->descricao,
					"listpagamentos"  => $listpagamentos,
					"data"   		=> inverteData($r->data),
					"time" 			=> $r->time,
					"listcomandas" 	=> $listcomandas,
					"valortotalpgt" => $totalPagamentos,
					"valortotalv"   => $totalVendas,
					"saldo" 				=> $saldo
				);
			}
		}

		echo json_encode($retorno);
		die();
	}



	}
