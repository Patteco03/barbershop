<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');

class Pagamento extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Pagamento_Model' , 'PagamentoM');

	}

	public function index() {
		$data                   = array();
		$data['URLADICIONAR']   = site_url('painel/pagamento/adicionar');
		$data['URLLISTAR']      = site_url('painel/pagamento');
		$data['BLC_DADOS']      = array();
		$data['BLC_SEMDADOS']   = array();
		$data['BLC_PAGINAS']    = array();

		$pagina         = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina-1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res    = $this->PagamentoM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID"         	=> $r->id,
					"NOME"       	=> $r->nome,
					"VALOR"			=> $r->valor,
					"URLEDITAR"    	=> site_url('painel/pagamento/editar/'.$r->id),
					"URLEXCLUIR"   	=> site_url('painel/pagamento/excluir/'.$r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens     = $this->PagamentoM->getTotal();
		$totalPaginas   = ceil($totalItens/LINHAS_PESQUISA_DASHBOARD);

		$indicePg       = 1;
		$pagina         = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina         = ($pagina==0)?1:$pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX']    = null;
			$data['URLPROXIMO'] = site_url('painel/pagamento?pagina='.($pagina+1));
		} else {
			$data['HABPROX']    = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR']= 'disabled';
			$data['URLANTERIOR']= '#';
		} else {
			$data['HABANTERIOR']= null;
			$data['URLANTERIOR']= site_url('painel/pagamento?pagina='.($pagina-1));
		}



		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK"      => ($indicePg==$pagina)?'active':null,
				"INDICE"    => $indicePg,
				"URLLINK"   => site_url('painel/pagamento?pagina='.$indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/pagamento_listar', $data);
	}

	public function adicionar(){
		$data = array();

		$data['ACAOFORM'] = site_url('painel/pagamento/salvar');
		$data['ACAO']    = 'Adicionar Pagamento';
		$data['BLC_COMISSAO'] = array();

		$data['id'] = '';
		$data['caixa_id'] = 1;
		$data['nome'] = '';
		$data['data'] = '';
		$data['valor'] = '';
		$data['observacao'] = '';



		$this->parser->parse('painel/pagamento_form', $data);
	}

	public function salvar(){

		$nome = $this->input->post('nome');
		$id = $this->input->post('id');
		$data = $this->input->post('data');
		$valor = $this->input->post('valor');
		$observacao = $this->input->post('observacao');
		$caixa_id = $this->input->post('caixa_id');


		$itens = array(
			'id' 		 => $id,
			'nome' => $nome,
			'data' => $data,
			'valor' => $valor,
			'observacao' => $observacao,
			'caixa_id' => $caixa_id
		);

		if ($id) {
			$id = $this->PagamentoM->update($itens, $id);
		} else {
			$id = $this->PagamentoM->post($itens);
		}

		if ($id) {
			$this->session->set_flashdata('sucesso', 'Pagamento inseridos com sucesso.');

			$valorDesconto = 0.00;

			$this->load->model('Caixa_Model', 'CaixaM');
			$this->load->model('Movimentacao_Model', 'MoviM');
			$res = $this->CaixaM->get(array(), FALSE, FALSE);
			if ($res) {
				foreach ($res as $r) {
					$valorDesconto = $r->saldo - $valor;
				}
			}

			$valorupdate = array(
				"id" => $caixa_id,
				"saldo" => $valorDesconto
			);
			$this->CaixaM->update($valorupdate, $caixa_id);
			$movimentacao = array(
				"data" => $data,
				"time" => date('H:i:s'), 
				"descricao"=> 'saida',
				"pagamento_id" => $id
				);
			$this->MoviM->post($movimentacao);
			redirect('painel/pagamento');
		} else {
			$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

			if ($id) {
				redirect('painel/pagamento/editar/'.$id);
			} else {
				redirect('painel/pagamento/adicionar');
			}
		}

	}

	public function editar($id) {
		$data               = array();
		$data['ACAO']       = 'Edição';
		$data['ACAOFORM']   = site_url('painel/pagamento/salvar');

		$data ['chk_habilita'] = null;

		$res    = $this->PagamentoM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach($res as $chave => $valor) {
				$data[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}


		$this->parser->parse('painel/pagamento_form', $data);
	}

	public function excluir($id) {
		$this->load->model('Caixa_Model', 'CaixaM');
		$valor = 0.00;
		$valorRetorno = 0.00;
		$caixa_id = 1;
		$pagamento = $this->PagamentoM->get(array("id" => $id), FALSE, FALSE);
		if ($pagamento) {
			foreach ($pagamento as $r) {
				$valor = $r->valor;
			}
		}
		$caixa = $this->CaixaM->get(array(), FALSE, FALSE);
		if ($caixa) {
			foreach ($caixa as $r) {
				$valorRetorno = $r->saldo + $valor;
			}
		}
		$valorupdate = array(
				"id" => $caixa_id,
				"saldo" => $valorRetorno
		);
		$this->CaixaM->update($valorupdate, $caixa_id);
		
		$res = $this->PagamentoM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Pagamento removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Pagamento não pode ser removido.');
		}

		redirect('painel/pagamento');
	}

}
