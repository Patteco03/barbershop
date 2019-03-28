<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Users_Model', 'UsersM');
	}

	public function index()
	{
		$data = array();
		$data['URLADICIONAR'] = site_url('painel/users/adicionar');
		$data['URLLISTAR'] = site_url('painel/users');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['BLC_PAGINAS'] = array();

		$pagina = $this->input->get('pagina');

		if (!$pagina) {
			$pagina = 0;
		} else {
			$pagina = ($pagina - 1) * LINHAS_PESQUISA_DASHBOARD;
		}

		$res = $this->UsersM->get(array(), FALSE, $pagina);

		if ($res) {
			foreach ($res as $r) {
				$data['BLC_DADOS'][] = array(
					"NOME" => $r->name,
					"USERNAME" => $r->username,
					"EMAIL" => $r->email,
					"ID" => $r->id,
					"STATUS" => ($r->status == '1') ? '<button class="btn btn-success">Ativo</button>' : '<button class="btn btn-danger">Inativo</button>',
					"URLEDITAR" => site_url('painel/users/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/users/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$totalItens = $this->UsersM->getTotal();
		$totalPaginas = ceil($totalItens / LINHAS_PESQUISA_DASHBOARD);

		$indicePg = 1;
		$pagina = $this->input->get('pagina');
		if (!$pagina) {
			$pagina = 1;
		}
		$pagina = ($pagina == 0) ? 1 : $pagina;

		if ($totalPaginas > $pagina) {
			$data['HABPROX'] = null;
			$data['URLPROXIMO'] = site_url('painel/users?pagina=' . ($pagina + 1));
		} else {
			$data['HABPROX'] = 'disabled';
			$data['URLPROXIMO'] = '#';
		}

		if ($pagina <= 1) {
			$data['HABANTERIOR'] = 'disabled';
			$data['URLANTERIOR'] = '#';
		} else {
			$data['HABANTERIOR'] = null;
			$data['URLANTERIOR'] = site_url('painel/users?pagina=' . $pagina - 1);
		}


		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK" => ($indicePg == $pagina) ? 'active' : null,
				"INDICE" => $indicePg,
				"URLLINK" => site_url('painel/users?pagina=' . $indicePg)
			);

			$indicePg++;
		}


		$this->parser->parse('painel/users_listar', $data);
	}

	public function perfil()
	{
		$data = array();

		$this->parser->parse('painel/perfil_usuario', $data);

	}

	public function adicionar()
	{

		$data = array();
		$data['ACAO'] = 'Novo';
		$data['ACAOFORM'] = site_url('painel/users/salvar');
		$data['id'] = '';
		$data['name'] = '';
		$data['username'] = '';
		$data['email'] = '';
		$data['password'] = '';
		$data['status'] = '1';
		$data['chk_1'] = null;
		$data['chk_0'] = null;
		$data['BLC_CARGO'] = array();

		$this->load->Model('Roles_Model', 'RolesM');
		$res = $this->RolesM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_CARGO'][] = array(
					"roles_id" => $r->id,
					"nome" => $r->role,
					"sel_cargo" => null
				);
			}
		}


		$this->parser->parse('painel/users_form', $data);
	}

	public function editar($id)
	{
		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/users/salvar');

		$res = $this->UsersM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}


		$data['chk_'.$res->status] = 'checked="checked"';


		$this->load->Model('Roles_Model', 'RolesM');
		$cargo = $this->RolesM->get(array(), FALSE, FALSE);

		if ($cargo) {
			foreach ($cargo as $r) {

				$data['BLC_CARGO'][] = array(
					"roles_id" => $r->id,
					"nome" => $r->role,
					"sel_cargo" => ($res->roles_id==$r->id)?'selected="selected"':null
				);
			}
		}


		$this->parser->parse('painel/users_form', $data);
	}

	public function salvar()
	{

		$idusuario = $this->input->post('idusuario');
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$cargo =   $this->input->post('roles_id');
		$status = $this->input->post('status');

		$erros = FALSE;
		$mensagem = null;

		if (!isset($status)){
			$status = 0;
		}

		if (!$name) {
			$erros = TRUE;
			$mensagem .= "Informe nome\n";
		}
		if (!$username) {
			$erros = TRUE;
			$mensagem .= "Informe o nome do Usuário\n";
		}

		if (!$password) {
			$erros = TRUE;
			$mensagem .= "Informe senha do usuário\n";
		}

		if (!$email) {
			$erros = TRUE;
			$mensagem .= "Informe o email do usuário.\n";
		} else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$erros = TRUE;
				$mensagem .= "Este email é inválido.\n";
			} else {
				$total = $this->UsersM->validaEmailDuplicado($idusuario, $email);
				if ($total > 0) {
					$erros = TRUE;
					$mensagem .= "Este email já está sendo utilizado.\n";
				}
			}
		}

		if (!$erros) {
			$itens = array(
				"name" => addcslashes($name, 'W') ,
				"username" =>  addcslashes($username, 'W'),
				"email" => $email,
				"status" => $status,
				"roles_id" => $cargo
			);

			if ($password) {

				$salt = hash('sha512', $password);
				$salt = base64_encode($salt);
				$salt = str_replace('+', '.', $salt);
				$hash = crypt('rasmuslerdorf', '$2y$10$'.$salt.'$');

				$itens['password'] = $hash;
				$itens['salt'] = $salt;
			}


			if ($idusuario) {
				$idusuario = $this->UsersM->update($itens, $idusuario);
			} else {
				$idusuario = $this->UsersM->post($itens);
			}

			if ($idusuario) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/users');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($idusuario) {
					redirect('painel/users/editar/'.$idusuario);
				} else {
					redirect('painel/users/adicionar');
				}
			}

		} else {
			$this->session->set_flashdata('error', nl2br($mensagem));
			if ($idusuario) {
				redirect('painel/users/editar/' . $idusuario);
			} else {
				redirect('painel/users/adicionar');
			}
		}

	}

	public function excluir($id) {
		$res = $this->UsersM->delete($id);

		if ($res) {
			$this->session->set_flashdata('sucesso', 'Usuário removido com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Usuário não pode ser removido.');
		}

		redirect('painel/users');
	}




}
