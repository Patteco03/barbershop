<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');

class Barber extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Barber_Model' , 'BarberM');

	}

	public function index() {
		$data                   = array();
		$data['URLADICIONAR']   = site_url('painel/barber/adicionar');
		$data['URLLISTAR']      = site_url('painel/barber');
		$data['BLC_DADOS']      = array();
		$data['BLC_SEMDADOS']   = array();
		$data['BLC_PAGINAS']    = array();

		$pagina         = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina-1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res    = $this->BarberM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID"         	=> $r->id,
					"NOME"       	=> $r->nome,
					"URLEDITAR"    	=> site_url('painel/barber/editar/'.$r->id),
					"URLEXCLUIR"   	=> site_url('painel/barber/excluir/'.$r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens     = $this->BarberM->getTotal();
		$totalPaginas   = ceil($totalItens/LINHAS_PESQUISA_DASHBOARD);

		$indicePg       = 1;
		$pagina         = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina         = ($pagina==0)?1:$pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX']    = null;
			$data['URLPROXIMO'] = site_url('painel/barber?pagina='.($pagina+1));
		} else {
			$data['HABPROX']    = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR']= 'disabled';
			$data['URLANTERIOR']= '#';
		} else {
			$data['HABANTERIOR']= null;
			$data['URLANTERIOR']= site_url('painel/barber?pagina='.($pagina-1));
		}



		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK"      => ($indicePg==$pagina)?'active':null,
				"INDICE"    => $indicePg,
				"URLLINK"   => site_url('painel/barber?pagina='.$indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/barber_listar', $data);
	}

	public function adicionar(){
		$data = array();

		$data['ACAOFORM'] = site_url('painel/barber/salvar');
		$data['ACAO']    = 'Adicionar Barbeiro';
		$data['BLC_COMISSAO'] = array();

		$data['id'] = '';
		$data['nome'] = '';



		$this->parser->parse('painel/barber_form', $data);
	}

	public function salvar(){

		$nome = $this->input->post('nome');
		$id = $this->input->post('id');

		$itens = array(
			'id' 		 => $id,
			'nome' => $nome
		);

		if ($id) {
			$id = $this->BarberM->update($itens, $id);
		} else {
			$id = $this->BarberM->post($itens);
		}

		if ($id) {
			$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
			redirect('painel/barber');
		} else {
			$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

			if ($id) {
				redirect('painel/barber/editar/'.$id);
			} else {
				redirect('painel/barber/adicionar');
			}
		}

	}

	public function editar($id) {
		$data               = array();
		$data['ACAO']       = 'Edição';
		$data['ACAOFORM']   = site_url('painel/barber/salvar');

		$data ['chk_habilita'] = null;

		$res    = $this->BarberM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach($res as $chave => $valor) {
				$data[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}


		$this->parser->parse('painel/barber_form', $data);
	}

	public function excluir($id) {
		$res = $this->BarberM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Barbeiro removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Barbeiro não pode ser removido.');
		}

		redirect('painel/barber');
	}

}
