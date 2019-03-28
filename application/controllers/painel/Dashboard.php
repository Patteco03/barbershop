<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Caixa_Model', 'CaixaM');
		$this->load->model('Cliente_Model', 'ClienteM');
		$this->load->model('HistoricoCaixa_Model', 'HistoricoM');
		$this->layout = LAYOUT_DASHBOARD;
	}

	public function index()
	{

		$data = array();
		$data['ACAO'] = site_url('painel/dashboard/aberturaCaixa');

		$cliente = $this->ClienteM->getTotal(array());
		$data['countCliente'] = $cliente;

		$his = $this->HistoricoM->get(array(), FALSE, FALSE);
		$sumHistorico = 0;
		if ($his) {
			foreach ($his as $r) {
				$sumHistorico = $sumHistorico += $r->valor;
				$data['sumhitorico'] = $sumHistorico;
			}
		}

		$res = $this->CaixaM->get(array(), FALSE, FALSE);
		if ($res) {
			foreach ($res as $r) {
				$data['data'] = strftime('%A, %d de %B de %Y', strtotime('today'));
				$data['idcaixa'] = 1;
				$data['valor'] = null;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}




		$this->parser->parse('dashboard', $data);

	}

	public function statusCaixa()
	{
		$res = $this->CaixaM->get(array(), FALSE, FALSE);

		$caixa = array();

		if ($res) {
			foreach ($res as $r) {
				$caixa [] = array(
					'status' => $r->status
				);
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		echo json_encode($caixa);
		die();
	}

	public function aberturaCaixa()
	{
		$idcaixa = $this->input->post('idcaixa');
		$valor = $this->input->post('valor');
		$status = 1;

		$erros = FALSE;
		$mensagem = null;

		if (!$valor) {
			$erros = TRUE;
			$mensagem = "Infome o Valor.<br>";
		}

		if (!$erros){
			$itens = array(
				'id' => $idcaixa,
				'saldo' => $valor,
				'status' => $status
			);

			$idcaixa = $this->CaixaM->update($itens, $idcaixa);

			if ($idcaixa) {
				$retorno = array(
					'codigo' => 0,
					'mensagem' => 'Abertura de caixa confirmada!'
				);
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
		}else{
			$retorno = array(
				'codigo' => 1,
				'mensagem' => $mensagem
			);
			echo json_encode($retorno);
			die();
		}


	}

	private function setURL(&$data)
	{
		$data = site_url('dashboard');
	}

}
