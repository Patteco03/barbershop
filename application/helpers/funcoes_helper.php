<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

if (! function_exists ( 'setURL' )) {
    function setURL(&$data, $controller) {
        $data ['URLLISTAR'] = ci_site_url ( "painel/{$controller}" );
        $data ['ACAOFORM'] = ci_site_url ( "painel/{$controller}/salvar" );
    }
}

if (! function_exists ( 'debug' )) {
    function debug($data, $die = false) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($die) {
            die();
        }
    }
}

if (! function_exists ( 'validaCPF' )) {

    /**
     * Valida se o CPF informado é válido
     *
     * @param integer $cpf
     */
    function validaCPF($cpf) {
        if (! is_numeric ( $cpf )) {
            return false;
        }

        $aCPFsBloqueados = array (
            "00000000000",
            "11111111111",
            "22222222222",
            "33333333333",
            "44444444444",
            "55555555555",
            "66666666666",
            "77777777777",
            "88888888888",
            "99999999999"
        );

        if (in_array ( $cpf, $aCPFsBloqueados )) {
            return false;
        }

        // DÍGITO VERIFICADOR

        $dv_informado = substr ( $cpf, 9, 2 );

        for($i = 0; $i <= 8; $i ++) {
            $digito [$i] = substr ( $cpf, $i, 1 );
        }

        // CALCULA O VALOR DO 10º DÍGITO DE VERIFICAÇÃO

        $posicao = 10;
        $soma = 0;

        for($i = 0; $i <= 8; $i ++) {
            $soma = $soma + $digito [$i] * $posicao;
            $posicao = $posicao - 1;
        }

        $digito [9] = $soma % 11;

        if ($digito [9] < 2) {
            $digito [9] = 0;
        } else {
            $digito [9] = 11 - $digito [9];
        }

        // CALCULA O VALOR DO 11º DÍGITO DE VERIFICAÇÃO
        $posicao = 11;
        $soma = 0;

        for($i = 0; $i <= 9; $i ++) {
            $soma = $soma + $digito [$i] * $posicao;
            $posicao = $posicao - 1;
        }

        $digito [10] = $soma % 11;

        if ($digito [10] < 2) {
            $digito [10] = 0;
        } else {
            $digito [10] = 11 - $digito [10];
        }

        $dv = $digito [9] * 10 + $digito [10];

        if ($dv != $dv_informado) {
            return false;
        }

        return true;
    }
}
if (! function_exists ( 'dateBR2MySQL' )) {

    /**
     * Converte dd/mm/yyyy -> Y-m-d
     *
     * @param string $valor
     * @return numeric
     */
    function dateBR2MySQL($valor) {
        $valor = explode ( "/", $valor );
        $valor = $valor [2] . '-' . $valor [1] . '-' . $valor [0];
        return $valor;
    }
}

if (! function_exists ( 'inverteData' )) {

    function inverteData($data){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data)));
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data)));
        }
    }
}
if (! function_exists ( 'dateMySQL2BR' )) {

    /**
     * Converte Y-m-d - > dd/mm/yyyy
     *
     * @param string $valor
     * @return numeric
     */
    function dateMySQL2BR($valor) {
        $date = date_create ( $valor );
        return date_format ( $date, 'd/m/Y' );
    }
}
if (! function_exists ( 'usuarioLogado' )) {

    /**
     * Verifica se o cliente está logado
     *
     * @return mixed
     */
    function usuarioLogado($redirecionaLogin = false) {
        $CI = &get_instance ();

        $sessao = $CI->session->userdata ( 'index' );

        if (isset ( $sessao ['idusuario'] )) {
            return TRUE;
        } else {
            if ($redirecionaLogin) {
                redirect('painel/login');
            }
            return FALSE;
        }
    }
}

if (! function_exists ( 'mascara' )) {

    /**
     * Modifica o valor para uma máscara
     *
     * @param string $valor            
     * @return string
     */
    function mascara($valor, $mascara) {
        $mascarado = '';
        $k = 0;
        
        for($i = 0; $i <= strlen ( $mascara ) - 1; $i ++) {
            if ($mascara [$i] == '#') {
                if (isset ( $valor [$k] )) {
                    $mascarado .= $valor [$k ++];
                }
            } else {
                if (isset ( $mascara [$i] )) {
                    $mascarado .= $mascara [$i];
                }
            }
        }
        
        return $mascarado;
    }
}


if (! function_exists ( '_formatear' )) {

    /**
     * Modifica o valor para uma máscara
     *
     * @param string $fecha            
     * @return string
     */
    function _formatear($fecha)
    {
        return strtotime(substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2)." " .substr($fecha, 10, 6)) * 1000;
    }
}


if (! function_exists ( 'evaluar' )) {

    /**
     * Modifica o valor para uma máscara
     *
     * @param string $valor            
     * @return string
     */
    function evaluar($valor) 
    {
        $nopermitido = array("'",'\\','<','>',"\"");
        $valor = str_replace($nopermitido, "", $valor);
        return $valor;
    }
}


;?>