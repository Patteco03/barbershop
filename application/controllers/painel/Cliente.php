<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Cliente extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Cliente_Model', 'ClienteM');

	}

	public function index()
	{
		$data = array();
		$data['URLADICIONAR'] = site_url('painel/cliente/adicionar');
		$data['URLLISTAR'] = site_url('painel/cliente');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['BLC_PAGINAS'] = array();

		$pagina = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina - 1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res = $this->ClienteM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID" => $r->id,
					"NOME" => $r->nome,
					"URLEDITAR" => site_url('painel/cliente/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/cliente/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens = $this->ClienteM->getTotal();
		$totalPaginas = ceil($totalItens / LINHAS_PESQUISA_DASHBOARD);

		$indicePg = 1;
		$pagina = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina = ($pagina == 0) ? 1 : $pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX'] = null;
			$data['URLPROXIMO'] = site_url('painel/cliente?pagina=' . ($pagina + 1));
		} else {
			$data['HABPROX'] = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR'] = 'disabled';
			$data['URLANTERIOR'] = '#';
		} else {
			$data['HABANTERIOR'] = null;
			$data['URLANTERIOR'] = site_url('painel/cliente?pagina=' . ($pagina - 1));
		}


		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK" => ($indicePg == $pagina) ? 'active' : null,
				"INDICE" => $indicePg,
				"URLLINK" => site_url('painel/cliente?pagina=' . $indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/cliente_listar', $data);
	}

	public function adicionar()
	{
		$data = array();

		$data['ACAOFORM'] = site_url('painel/cliente/salvar');
		$data['ACAO'] = 'Adicionar Cliente';

		$data['id'] = '';
		$data['nome'] = '';
		$data['observacao'] = '';
		$data['email'] = '';
		$data['telefone'] = '';
		$data['cep'] = '';
		$data['rua'] = '';
		$data['bairro'] = '';
		$data['cidade'] = '';
		$data['uf'] = '';
		$data['datanascimento'] = '';


		$this->parser->parse('painel/cliente_form', $data);
	}

	public function salvar()
	{

		$nome = $this->input->post('nome');
		$id = $this->input->post('id');
		$observacao = $this->input->post('observacao');
		$email = $this->input->post('email');
		$telefone = $this->input->post('telefone');
		$cep = $this->input->post('cep');
		$rua = $this->input->post('rua');
		$bairro = $this->input->post('bairro');
		$cidade = $this->input->post('cidade');
		$uf = $this->input->post('uf');
		$datanascimento = $this->input->post('datanascimento');


		$erros = FALSE;
		$mensagem = null;

		if (!$cep){
			$erros = TRUE;
			$mensagem .= "Informe o cep.\n";
		}

		if (!$rua){
			$erros = TRUE;
			$mensagem .= "Informe o rua.\n";
		}

		if (!$bairro){
			$erros = TRUE;
			$mensagem .= "Informe o bairro.\n";
		}

		if (!$datanascimento){
			$erros = TRUE;
			$mensagem .= "Informe a data de nascimento.\n";
		}

		if (!$email) {
			$erros = TRUE;
			$mensagem .= "Informe o email do cliente.\n";
		} else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$erros = TRUE;
				$mensagem .= "Este email é inválido.\n";
			} else {
				$total = $this->ClienteM->validaEmailDuplicado($id, $email);
				if ($total > 0) {
					$erros = TRUE;
					$mensagem .= "Este email já está sendo utilizado.\n";
				}
			}
		}

		if (!$erros) {
			$itens = array(
				'id' => $id,
				'nome' => $nome,
				'observacao' => $observacao,
				'email' => $email,
				'telefone' => $telefone,
				'cep' => $cep,
				'bairro' => $bairro,
				'rua' => $rua,
				'cidade' => $cidade,
				'datanascimento' => $datanascimento,
				'uf' => $uf
			);

			if ($id) {
				$id = $this->ClienteM->update($itens, $id);
			} else {
				$id = $this->ClienteM->post($itens);
			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/cliente');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($id) {
					redirect('painel/cliente/editar/' . $id);
				} else {
					redirect('painel/cliente/adicionar');
				}
			}
		} else {
			$this->session->set_flashdata('erro', nl2br($mensagem));
			if ($id) {
				redirect('painel/cliente/editar/' . $id);
			} else {
				redirect('painel/cliente/adicionar');
			}
		}


	}

	public function editar($id)
	{
		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/cliente/salvar');

		$data ['chk_habilita'] = null;

		$res = $this->ClienteM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}


		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$this->parser->parse('painel/cliente_form', $data);
	}

	public function excluir($id)
	{
		$res = $this->ClienteM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Cliente removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Cliente não pode ser removido.');
		}

		redirect('painel/cliente');
	}

}
