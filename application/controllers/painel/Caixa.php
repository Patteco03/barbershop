<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Caixa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Caixa_Model', 'CaixaM');

	}

	public function index()
	{
		$data = array();
		$data['URLADICIONAR'] = site_url('painel/caixa/adicionar');
		$data['URLRELATORIO'] = site_url('painel/historicocaixa');
		$data['URLLISTAR'] = site_url('painel/caixa');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['BLC_PAGINAS'] = array();
		$data['SALDO'] = null;
		$pagina = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina - 1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res = $this->CaixaM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID" => $r->id,
					"NOME" => $r->nome,
					"URLEDITAR" => site_url('painel/caixa/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/caixa/excluir/' . $r->id),
					"URLFECHARCAIXA" => site_url('painel/caixa/registrarcaixa/' . $r->id)
				);

				$data['SALDO'] = $r->saldo;
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens = $this->CaixaM->getTotal();
		$totalPaginas = ceil($totalItens / LINHAS_PESQUISA_DASHBOARD);

		$indicePg = 1;
		$pagina = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina = ($pagina == 0) ? 1 : $pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX'] = null;
			$data['URLPROXIMO'] = site_url('painel/caixa?pagina=' . ($pagina + 1));
		} else {
			$data['HABPROX'] = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR'] = 'disabled';
			$data['URLANTERIOR'] = '#';
		} else {
			$data['HABANTERIOR'] = null;
			$data['URLANTERIOR'] = site_url('painel/caixa?pagina=' . ($pagina - 1));
		}


		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK" => ($indicePg == $pagina) ? 'active' : null,
				"INDICE" => $indicePg,
				"URLLINK" => site_url('painel/caixa?pagina=' . $indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/caixa_listar', $data);
	}

	public function adicionar()
	{

		date_default_timezone_set('America/Rio_Branco');
		$date = date('Y-m-d');

		$data = array();

		$data['ACAOFORM'] = site_url('painel/caixa/salvar');
		$data['ACAO'] = 'Adicionar Caixa';

		$data['id'] = '';
		$data['nome'] = '';
		$data['saldo'] = '';
		$data['data'] = $date;


		$this->parser->parse('painel/caixa_form', $data);
	}

	public function salvar()
	{

		$nome = $this->input->post('nome');
		$id = $this->input->post('id');
		$saldo = $this->input->post('saldo');

		$itens = array(
			'id' => $id,
			'nome' => $nome,
			'saldo' => $saldo
		);

		if ($id) {
			$id = $this->CaixaM->update($itens, $id);
		} else {
			$id = $this->CaixaM->post($itens);
		}

		if ($id) {
			$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
			redirect('painel/caixa');
		} else {
			$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

			if ($id) {
				redirect('painel/caixa/editar/' . $id);
			} else {
				redirect('painel/caixa/adicionar');
			}
		}

	}

	public function editar($id)
	{
		date_default_timezone_set('America/Rio_Branco');
		$date = date('Y-m-d');

		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/caixa/salvar');
		$data['data'] = inverteData($date);
		$data['chk_habilita'] = null;

		$res = $this->CaixaM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}


		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$this->parser->parse('painel/caixa_form', $data);
	}

	public function excluir($id)
	{
		$res = $this->CaixaM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Caixa removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Não pode ser removido.');
		}

		redirect('painel/caixa');
	}

	public function registrarcaixa($id)
	{
		date_default_timezone_set('America/Rio_Branco');
		$date = date('Y-m-d');

		$data = array();
		$data['ACAO'] = 'Ver';
		$data['URLVOLTAR'] = site_url('painel/caixa');
		$data['URLFORM'] = site_url('painel/historicocaixa/salvar');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['VALORTOTAL'] = null;

		$data['id'] = '';
		$data['data'] = $date;
		$data['valor'] = '';
		$data['caixa_id'] = $id;

		$this->load->model('Vendas_Model', 'VendasM');
		$res = $this->VendasM->get(array('data' => $date), FALSE, FALSE);
		$valor = 0;
		if ($res) {
			foreach ($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID" => $r->id,
					"DATA" => inverteData($r->data),
					"VALOR" => $r->precofinal
				);

				$valortotal = $valor += $r->precofinal;
				$data['VALORTOTAL'] = number_format($valortotal, 2 , ',', '');
				$data['valor'] = $valortotal;
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$this->parser->parse('painel/registrarcaixa_listar', $data);
	}

}
