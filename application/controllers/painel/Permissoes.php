<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Permissoes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Roles_Model', 'RolesM');

	}

	public function index() {
		$data                   = array();
		$data['URLADICIONAR']   = site_url('painel/permissoes/adicionar');
		$data['URLLISTAR']      = site_url('painel/permissoes');
		$data['BLC_DADOS']      = array();
		$data['BLC_SEMDADOS']   = array();
		$data['BLC_PAGINAS']    = array();

		$pagina         = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina-1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res    = $this->RolesM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach($res as $r) {

				$data['BLC_DADOS'][] = array(
					"ID"         	=> $r->id,
					"NOME"       	=> $r->role,
					"URLEDITAR"    	=> site_url('painel/permissoes/editar/'.$r->id),
					"URLEXCLUIR"   	=> site_url('painel/permissoes/excluir/'.$r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens     = $this->RolesM->getTotal();
		$totalPaginas   = ceil($totalItens/LINHAS_PESQUISA_DASHBOARD);

		$indicePg       = 1;
		$pagina         = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina         = ($pagina==0)?1:$pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX']    = null;
			$data['URLPROXIMO'] = site_url('painel/permissoes?pagina='.($pagina+1));
		} else {
			$data['HABPROX']    = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR']= 'disabled';
			$data['URLANTERIOR']= '#';
		} else {
			$data['HABANTERIOR']= null;
			$data['URLANTERIOR']= site_url('painel/permissoes?pagina='.($pagina-1));
		}



		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK"      => ($indicePg==$pagina)?'active':null,
				"INDICE"    => $indicePg,
				"URLLINK"   => site_url('painel/permissoes?pagina='.$indicePg)
			);

			$indicePg++;
		}

		$this->parser->parse('painel/permissoes_listar', $data);
	} 

	public function adicionar(){
		$data = array();

		$data['ACAOFORM'] = site_url('painel/permissoes/salvar');
		$data ['ACAO']    = 'Nova Permissão';

		$data ['id'] = '';
		$data ['role'] = '';


		$this->parser->parse('painel/permissoes_form', $data);
	}

	public function salvar(){

		$nomePermissao = $this->input->post('nome');
		$id = $this->input->post('id');

		$permissoes = array(

			'aCliente' => $this->input->post('aCliente'),
			'eCliente' => $this->input->post('eCliente'),
			'dCliente' => $this->input->post('dCliente'),
			'vCliente' => $this->input->post('vCliente'),

			'aProduto' => $this->input->post('aProduto'),
			'eProduto' => $this->input->post('eProduto'),
			'dProduto' => $this->input->post('dProduto'),
			'vProduto' => $this->input->post('vProduto'),

			'aServico' => $this->input->post('aServico'),
			'eServico' => $this->input->post('eServico'),
			'dServico' => $this->input->post('dServico'),
			'vServico' => $this->input->post('vServico'),

			'aOs' => $this->input->post('aOs'),
			'eOs' => $this->input->post('eOs'),
			'dOs' => $this->input->post('dOs'),
			'vOs' => $this->input->post('vOs'),

			'aVenda' => $this->input->post('aVenda'),
			'eVenda' => $this->input->post('eVenda'),
			'dVenda' => $this->input->post('dVenda'),
			'vVenda' => $this->input->post('vVenda'),

			'aArquivo' => $this->input->post('aArquivo'),
			'eArquivo' => $this->input->post('eArquivo'),
			'dArquivo' => $this->input->post('dArquivo'),
			'vArquivo' => $this->input->post('vArquivo'),

			'aLancamento' => $this->input->post('aLancamento'),
			'eLancamento' => $this->input->post('eLancamento'),
			'dLancamento' => $this->input->post('dLancamento'),
			'vLancamento' => $this->input->post('vLancamento'),

			'cUsuario' => $this->input->post('cUsuario'),
			'cEmitente' => $this->input->post('cEmitente'),
			'cPermissao' => $this->input->post('cPermissao'),
			'cBackup' => $this->input->post('cBackup'),

			'rCliente' => $this->input->post('rCliente'),
			'rProduto' => $this->input->post('rProduto'),
			'rServico' => $this->input->post('rServico'),
			'rOs' => $this->input->post('rOs'),
			'rVenda' => $this->input->post('rVenda'),
			'rFinanceiro' => $this->input->post('rFinanceiro'),

		);
		$permissoes = serialize($permissoes);

		$itens = array(
			'role' 		 => $nomePermissao,
			'permissoes' => $permissoes
		);

		if ($id) {
			$id = $this->RolesM->update($itens, $id);
		} else {
			$id = $this->RolesM->post($itens);
		}

		if ($id) {
			$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
			redirect('painel/permissoes');
		} else {
			$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

			if ($id) {
				redirect('painel/permissoes/editar/'.$id);
			} else {
				redirect('painel/permissoes/adicionar');
			}
		}

	}

	public function editar($id) {
		$data               = array();
		$data['ACAO']       = 'Edição';
		$data['ACAOFORM']   = site_url('painel/permissoes/salvar');

		$data ['chk_habilita'] = null;

		$res    = $this->RolesM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach($res as $chave => $valor) {
				$data[$chave] = $valor;
			}


		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}

		$permissoes = unserialize($res->permissoes);	

		$this->parser->parse('painel/permissoes_form', $data);
	}

	public function excluir($id) {
		$res = $this->RolesM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Usuário removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Usuário não pode ser removido.');
		}

		redirect('painel/permissoes');
	}

}