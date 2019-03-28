<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( "Users_Model", "UsuarioM" );
		$this->load->model ( "Attempt_Model", "AttemptM" );
		$this->layout = '';
	}
	public function index() {

		$this->load->view ( "painel/login" );
	}
	public function verifica() {

		$username = $this->input->post ( "username" );
		$senha = $this->input->post ( "password" );

		$this->load->library ( 'form_validation' );

		$this->form_validation->set_rules ( 'username', 'username', 'required' );
		$this->form_validation->set_rules ( 'password', 'password', 'required' );

		if ($this->form_validation->run () == FALSE) {
			$this->session->set_flashdata ( 'erro', 'Informe os campos corretamente.' . validation_errors () );
			redirect ( 'painel/login' );
		}


		$res = $this->UsuarioM->get ( array(
			'username'  => $username
		));

		$statusenha = false;

		if ($res) {

			$itens    = array();
			$user_id  = null;
			$datahora = date('Y-m-d H:i:s');
			foreach ($res as $r ) {



				$itens = array (
					"users_id"  => $r->id,
					"name"      => $r->name,
					"email"     => $r->email,
					"username"  => $username,
					"status"    => $r->status,
					"roles_id"  => $r->roles_id
				);

				$user_id = $r->id;

				$salt = hash('sha512', $senha);
				$salt = base64_encode($salt);
				$salt = str_replace('+', '.', $salt);
				$hash = crypt('rasmuslerdorf', '$2y$10$'.$salt.'$');

				if ($hash === $r->password){
					$statusenha = true;
				}
				$status = $r->status;
			}

			$ExistemTentativas = $this->AttemptM->TotalDeTentaticas(array("users_id" => $user_id));

			if ($ExistemTentativas < 5) {
				if ($statusenha == 'true' && $status == '1') {

					$this->AttemptM->LimparTentativas($user_id);

					$this->session->set_userdata ( "loginusers", $itens );
					redirect ( "painel" );
				}else{

					$itensTentativa = array(
						"users_id"  => $user_id,
						"create_at" => $datahora
					);

					$this->AttemptM->RegistrarTentativa($itensTentativa);

					$this->session->set_flashdata ( 'erro', 'Senha incorreta ou usuário bloqueado.' );
					redirect ( "painel/login" );
				}
			}else{

				$bloqueUsuario = array(
					"status"   => '0'
				);

				$this->UsuarioM->update($bloqueUsuario, $user_id);

				$this->session->set_flashdata ( 'erro', 'Você escedeu o número de tentativas, usuário bloqueado!' );
				redirect ( "painel/login" );
			}


		} else {
			$this->session->set_flashdata ( 'erro', 'Usuário não encontrado.' );
			redirect ( "painel/login" );
		}


	}
	public function sair() {
		$this->session->unset_userdata ( "loginusers" );
		redirect ( "painel/login" );
	}

}
