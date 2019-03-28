<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Service extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Service_Model', 'ServiM');
		$this->load->model('Comissao_Model', 'ComissaoM');
	}

	public function index()
	{
		$data = array();
		$data['URLLISTAR'] = site_url('painel/service');
		$data['URLADICIONAR'] = site_url('painel/service/adicionar');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();



		$res = $this->ServiM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {

				$foComissao = $this->ComissaoM->get(array("id" => $r->comissao_id), FALSE, FALSE);

				$valorComissao = null;
				if ($foComissao) {
					foreach ($foComissao as $f) {
						$valorComissao = $f->valor;
					}
				}

				$data['BLC_DADOS'][] = array(
					"NOME" => $r->nome,
					"ID" => $r->id,
					"PRECO" => $r->preco,
					"COMISSAO" => $valorComissao,
					"URLEDITAR" => site_url('painel/service/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/service/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}


		$this->parser->parse('painel/service_listar', $data);
	}

	public function adicionar()
	{

		$data = array();
		$data['ACAO'] = 'Novo';
		$data['ACAOFORM'] = site_url('painel/service/salvar');
		$data['id'] = null;
		$data['nome'] = null;
		$data['preco'] = null;

		$res = $this->ComissaoM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_COMISSAO'][] = array(
					"comissao_id" => $r->id,
					"nome" => $r->nome,
					"por" => $r->valor,
					"sel_com" => null
				);
			}
		}


		$this->parser->parse('painel/service_form', $data);
	}

	public function editar($id)
	{
		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/service/salvar');

		$res = $this->ServiM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$comissao = $this->ComissaoM->get(array(), FALSE, FALSE);

		if ($comissao) {
			foreach ($comissao as $r) {

				$data['BLC_COMISSAO'][] = array(
					"comissao_id" => $r->id,
					"nome" => $r->nome,
					"por" => $r->valor,
					"sel_com" => ($res->comissao_id == $r->id) ? 'selected="selected"' : null
				);
			}
		}

		$this->parser->parse('painel/service_form', $data);
	}

	public function salvar()
	{

		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$preco = $this->input->post('preco');
		$comissao = $this->input->post('comissao');

		$erros = FALSE;
		$mensagem = null;

		if (!$name) {
			$erros = TRUE;
			$mensagem .= "Informe nome\n";
		}
		if (!$preco) {
			$erros = TRUE;
			$mensagem .= "Informe o preço\n";
		}


		if (!$erros) {
			$itens = array(
				"id" => $id,
				"nome" => addcslashes($name, 'W') ,
				"preco" => $preco,
				'comissao_id' => $comissao
			);


			if ($id) {
				$id = $this->ServiM->update($itens, $id);
			} else {
				$id = $this->ServiM->post($itens);
			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/service');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($id) {
					redirect('painel/service/editar/'.$id);
				} else {
					redirect('painel/service/adicionar');
				}
			}

		} else {
			$this->session->set_flashdata('error', nl2br($mensagem));
			if ($id) {
				redirect('painel/service/editar/' . $id);
			} else {
				redirect('painel/service/adicionar');
			}
		}

	}

	public function excluir($id) {
		$res = $this->ServiM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Serviço removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Serviço não pode ser removido.');
		}

		redirect('painel/product');
	}

	public function getService() {

		$id = $this->input->post('id');

		$res = $this->ServiM->get(array("id" => $id), FALSE, FALSE);
		$retorno = array();
		if ($res) {
			foreach ($res as $r) {

				$retorno [] = array(
					"nome"       => $r->nome,
					"id"         => $r->id,
					"preco"      => $r->preco,
				);
			}
		}

		echo json_encode($retorno);
		die();

	}



}
