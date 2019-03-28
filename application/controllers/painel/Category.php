<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Category_Model' , 'CatM');

	}


	public function adicionar(){
		$data = array();

		$data['ACAOFORM'] = site_url('painel/category/salvar');
		$data['ACAO']    = 'Adicionar Categoria';

		$data['id'] = '';
		$data['name'] = '';


		$this->parser->parse('painel/category_form', $data);
	}

	public function salvar(){

		$nome = $this->input->post('name');
		$id = $this->input->post('id');

		$itens = array(
			'id' 	=> $id,
			'name' 	=> $nome,
		);

		if ($id) {
			$id = $this->CatM->update($itens, $id);
		} else {
			$id = $this->CatM->post($itens);
		}

		if ($id) {
			$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
			redirect('painel/product');
		} else {
			$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

			if ($id) {
				redirect('painel/category/editar/'.$id);
			} else {
				redirect('painel/category/adicionar');
			}
		}

	}

	public function editar($id) {
		$data               = array();
		$data['ACAO']       = 'Edição';
		$data['ACAOFORM']   = site_url('painel/category/salvar');

		$data ['chk_habilita'] = null;

		$res    = $this->CatM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach($res as $chave => $valor) {
				$data[$chave] = $valor;
			}


		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$this->parser->parse('painel/category_form', $data);
	}

	public function excluir($id) {
		$res = $this->CatM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Categoria removida com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Categoria não pode ser removida.');
		}

		redirect('painel/product');
	}

}
