<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Comissao extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Comissao_Model', 'ComissaoM');

	}

	public function index()
	{
		$data = array();
		$data['URLADICIONAR'] = site_url('painel/comissao/adicionar');
		$data['URLLISTAR'] = site_url('painel/comissao');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['BLC_PAGINAS'] = array();

		$pagina = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina - 1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res = $this->ComissaoM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID" => $r->id,
					"NOME" => $r->nome,
					"PORCENTAGEM" => $r->valor,
					"URLEDITAR" => site_url('painel/comissao/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/comissao/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens = $this->ComissaoM->getTotal();
		$totalPaginas = ceil($totalItens / LINHAS_PESQUISA_DASHBOARD);

		$indicePg = 1;
		$pagina = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina = ($pagina == 0) ? 1 : $pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX'] = null;
			$data['URLPROXIMO'] = site_url('painel/comissao?pagina=' . ($pagina + 1));
		} else {
			$data['HABPROX'] = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR'] = 'disabled';
			$data['URLANTERIOR'] = '#';
		} else {
			$data['HABANTERIOR'] = null;
			$data['URLANTERIOR'] = site_url('painel/comissao?pagina=' . ($pagina - 1));
		}


		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK" => ($indicePg == $pagina) ? 'active' : null,
				"INDICE" => $indicePg,
				"URLLINK" => site_url('painel/comissao?pagina=' . $indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/comissao_listar', $data);
	}

	public function adicionar()
	{
		$data = array();

		$data['ACAOFORM'] = site_url('painel/comissao/salvar');
		$data['ACAO'] = 'Adicionar Comissão';

		$data['id'] = '';
		$data['nome'] = '';
		$data['valor'] = '';


		$this->parser->parse('painel/comissao_form', $data);
	}

	public function salvar()
	{

		$id = $this->input->post('id');
		$nome = $this->input->post('nome');
		$porcentagem = $this->input->post('porcentagem');

		$erros = FALSE;
		$mensagem = null;

		if (!$nome) {
			$erros = TRUE;
			$mensagem .= "Informe o nome.\n";
		}

		if (!$porcentagem) {
			$erros = TRUE;
			$mensagem .= "Informe a porcentagem.\n";
		}

		if (!$erros) {

			$itens = array(
				'id' => $id,
				'nome' => $nome,
				'valor' => $porcentagem
			);

			if ($id) {
				$id = $this->ComissaoM->update($itens, $id);
			} else {
				$id = $this->ComissaoM->post($itens);
			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/comissao');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($id) {
					redirect('painel/comissao/editar/' . $id);
				} else {
					redirect('painel/comissao/adicionar');
				}
			}

		} else {
			$this->session->set_flashdata('erro', nl2br($mensagem));
			if ($id) {
				redirect('painel/comissao/editar/' . $id);
			} else {
				redirect('painel/comissao/adicionar');
			}
		}

	}

	public function editar($id)
	{
		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/comissao/salvar');

		$data ['chk_habilita'] = null;

		$res = $this->ComissaoM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}


		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$this->parser->parse('painel/comissao_form', $data);
	}

	public function excluir($id)
	{
		$res = $this->ComissaoM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Comissão removida com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Comissão não pode ser removida.');
		}

		redirect('painel/comissao');
	}

}
