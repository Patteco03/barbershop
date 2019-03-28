<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');
class Product extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Product_Model', 'ProM');
		$this->load->model('Category_Model', 'CatM');
		$this->load->model('Estoque_Model', 'EstoqueM');
	}

	public function index()
	{
		$data = array();
		$data['URLADICIONAR'] = site_url('painel/product/adicionar');
		$data['URLADICIONARCATEGORY'] = site_url('painel/category/adicionar');
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();

		$data['BLC_CATEGORY'] = array();
		$data['BLCSEM_CATEGORY'] = array();

		$res = $this->ProM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {
				$categoria = null;

				$cat = $this->CatM->get(array("id" => $r->category_id), FALSE, FALSE);

				foreach ($cat as $c) {
					$categoria = $c->name;
				}

				$searchEstoque = $this->EstoqueM->get(array("product_id" => $r->id), FALSE, FALSE);
				$estoque = 0;
				if ($searchEstoque) {
					foreach ($searchEstoque as $s) {
						$estoque = $s->quantidade;
					}
				}else{
					$estoque = 0;
				}

				$data['BLC_DADOS'][] = array(
					"NOME" => $r->nome,
					"ID" => $r->id,
					"PRECO" => $r->preco,
					"CATEGORY" => $categoria,
					"QTDESTOQUE" => $estoque,
					"ESTOQUE" => site_url('painel/product/estoque/'.$r->id),
					"URLEDITAR" => site_url('painel/product/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/product/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLC_SEMDADOS'][] = array();
		}

		$listcat = $this->CatM->get(array(), FALSE, FALSE);

		if ($listcat) {
			foreach ($listcat as $r) {
				$data['BLC_CATEGORY'][] = array(
					"NOME" => $r->name,
					"ID" => $r->id,
					"URLEDITAR" => site_url('painel/category/editar/' . $r->id),
					"URLEXCLUIR" => site_url('painel/category/excluir/' . $r->id)
				);
			}
		} else {
			$data['BLCSEM_CATEGORY'][] = array();
		}


		$this->parser->parse('painel/product_listar', $data);
	}

	public function adicionar()
	{

		$data = array();
		$data['ACAO'] = 'Novo';
		$data['ACAOFORM'] = site_url('painel/product/salvar');
		$data['id'] = null;
		$data['nome'] = null;
		$data['preco'] = null;
		$data['observacao'] = null;
		$data['sel_cat'] = null;
		$data['BLC_CATEGORY'] = array();

		$this->load->Model('Category_Model', 'CategoryM');
		$res = $this->CategoryM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {

				$data['BLC_CATEGORY'][] = array(
					"category_id" => $r->id,
					"nome" => $r->name,
					"sel_cargo" => null
				);
			}
		}


		$this->parser->parse('painel/product_form', $data);
	}

	public function editar($id)
	{
		$data = array();
		$data['ACAO'] = 'Edição';
		$data['ACAOFORM'] = site_url('painel/product/salvar');

		$res = $this->ProM->get(array("id" => $id), TRUE);

		if ($res) {
			foreach ($res as $chave => $valor) {
				$data[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado.');
		}


		$cat = $this->CatM->get(array(), FALSE, FALSE);

		if ($cat) {
			foreach ($cat as $r) {

				$data['BLC_CATEGORY'][] = array(
					"category_id" => $r->id,
					"nome" => $r->name,
					"sel_cat" => ($res->category_id==$r->id)?'selected="selected"':null
				);
			}
		}


		$this->parser->parse('painel/product_form', $data);
	}

	public function salvar()
	{

		$idproduct = $this->input->post('id');
		$name = $this->input->post('name');
		$preco = $this->input->post('preco');
		$observacao = $this->input->post('observacao');
		$category_id = $this->input->post('category');

		$erros = FALSE;
		$mensagem = null;

		if (!isset($status)){
			$status = 0;
		}

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
				"id" => $idproduct,
				"nome" => addcslashes($name, 'W') ,
				"observacao" =>  addcslashes($observacao, 'W'),
				"preco" => $preco,
				"category_id" => $category_id
			);


			if ($idproduct) {
				$idproduct = $this->ProM->update($itens, $idproduct);
			} else {
				$idproduct = $this->ProM->post($itens);
			}

			if ($idproduct) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/product');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($idproduct) {
					redirect('painel/product/editar/'.$idproduct);
				} else {
					redirect('painel/product/adicionar');
				}
			}

		} else {
			$this->session->set_flashdata('error', nl2br($mensagem));
			if ($idproduct) {
				redirect('painel/product/editar/' . $idproduct);
			} else {
				redirect('painel/product/adicionar');
			}
		}

	}

	public function excluir($id) {
		$this->load->model('ComandaProduto_Model', 'ComandM');

		$searchComandaProduto = $this->ComandM->get(array("product_id" => $id), FALSE,FALSE);
		$retorno = FALSE;
		if (isset($searchComandaProduto)) {
			foreach ($searchComandaProduto as $key) {
				if ($key) {
					$retorno = TRUE;
				}
			}
		}

		if ($retorno == true) {
			$this->session->set_flashdata('error', 'Produto inserido na comanda não é possivel remover.');
			redirect('painel/product');
		}else{
			$res = $this->ProM->delete($id);

			if ($res) {
				$this->session->set_flashdata('sucesso', 'Produto removido com sucesso.');
			} else {
				$this->session->set_flashdata('error', 'Produto não pode ser removido.');
			}
			redirect('painel/product');
		}

		

		
	}

	public function getProdutos() {

		$id = $this->input->post('id');

		$res = $this->ProM->get(array("id" => $id), FALSE, FALSE);
		$retorno = array();
		if ($res) {
			foreach ($res as $r) {
				$categoria = null;

				$cat = $this->CatM->get(array("id" => $r->category_id), FALSE, FALSE);

				foreach ($cat as $c) {
					$categoria = $c->name;
				}

				$retorno [] = array(
					"nome"       => $r->nome,
					"id"         => $r->id,
					"preco"      => $r->preco,
					"category"   => $categoria,
					"observacao" => $r->observacao
				);
			}
		}

		echo json_encode($retorno);
		die();

	}

	public  function estoque($id){
		$data = array();
		$data['ACAO'] = 'Novo';
		$data['ACAOFORM'] = site_url('painel/product/slvEstoque');
		$data['id'] = null;
		$data['idproduto'] = $id;

		$data['nomeproduto'] = null;

		$res = $this->ProM->get(array("id" => $id), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {
				$data['nomeproduto'] = $r->nome;
			}
		}

		$searchEstoque = $this->EstoqueM->get(array("product_id" => $id), FALSE, FALSE);

		if ($searchEstoque) {
			foreach ($searchEstoque as $s) {
				$data['quantidade'] = $s->quantidade;
				$data['id'] = $s->id;
			}
		}else{
			$data['quantidade'] = 0;
		}

		$this->parser->parse('painel/estoque_form', $data);
	}

	public function slvEstoque()
	{

		$id = $this->input->post('id');
		$idproduto = $this->input->post('idproduto');
		$quantidade = $this->input->post('quantidade');


		$erros = FALSE;
		$mensagem = null;

		if (!$quantidade) {
			$erros = TRUE;
			$mensagem .= "Informe nome\n";
		}


		if (!$erros) {
			$itens = array(
				"id" => $id,
				"product_id" => $idproduto ,
				"quantidade" => $quantidade
			);


			if ($id) {
				$id = $this->EstoqueM->update($itens, $id);
			} else {
				$id = $this->EstoqueM->post($itens);
			}

			if ($id) {
				$this->session->set_flashdata('sucesso', 'Dados inseridos com sucesso.');
				redirect('painel/product');
			} else {
				$this->session->set_flashdata('error', 'Ocorreu um erro ao realizar a operação.');

				if ($id) {
					redirect('painel/product/estoque/'.$id);
				} else {
					redirect('painel/product/adicionar');
				}
			}

		} else {
			$this->session->set_flashdata('error', nl2br($mensagem));
			if ($id) {
				redirect('painel/product/editar/' . $id);
			} else {
				redirect('painel/product/adicionar');
			}
		}

	}



}
