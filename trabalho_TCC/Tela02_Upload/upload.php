<?php 

function conect(){
    $db=new mysqli('localhost','graneleiro','12345','portos');
    if($db->connect_errno) {
        echo 'Failed' . $db->connect_error;
        exit();
    }else{
        return $db;
    }
}


function upload($nome){
    $arquivo = $_FILES[$nome]["tmp_name"];
    $name = $_FILES[$nome]["name"];
   
    $ext = explode(".", $name);
    $extensao = end($ext);
    if($extensao != "csv"){
        echo "Extensão Inválida";
    }else{
        $objeto = fopen($arquivo, 'r');
        
        switch ($nome) {
            case 'atracacao':
                importaAtracacaoBD($objeto);      
                # code...
                break;
            case 'navio':
                importaNavioBD($objeto);      
                # code...
                break;
            case 'operacao':
                importaOperacaoBD($objeto);      
                # code...
                break;
            case 'portos':
                importaPortosBD($objeto);      
                # code...
                break;
            case 'rota':
                importaRotaBD($objeto);      
                # code...
                break;
            case 'tipoCarga':
                importaTipoCargaoBD($objeto);      
                # code...
                break;                            
            default:
                # code...
                break;
        }
    }
}


function importaNavioBD($objeto){
    $db = conect();
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query("INSERT INTO `navio` (`id_navio`, `id_tipo_carga`, `IMO`, `descricao`) VALUES ('{$dados[0]}', '{$dados[1]}', '{$dados[2]}', '{$dados[3]}');");
    }
}

function importaTipoCargaoBD($objeto){
    $db = conect();   
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query( "INSERT INTO `tipo_carga` (`id_tipo_carga`, `descricao`, `peso`) VALUES ( '{$dados[0]}', '{$dados[1]}', '{$dados[2]}');");
    }
}

function importaAtracacaoBD($objeto){
    $db = conect();   
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query("INSERT INTO atracacao (`id_atracacao`, `IMO`, `status`, `descricao`) VALUES ('{$dados[0]}', '{$dados[1]}', '{$dados[2]}', '{$dados[3]}')");
    }
}

function importaOperacaoBD($objeto){
    $db = conect();   
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query("INSERT INTO operacao (`id_operacao`,`id_atracacao`, `datetimeoperacao`, `descricao`, `inicio`, `fim`, `quantidade`) VALUES ('{$dados[0]}', '{$dados[1]}', '{$dados[2]}', '{$dados[3]}', '{$dados[4]}', '{$dados[5]}', '{$dados[6]}')");
    }
}

function importaPortosBD($objeto){
    $db = conect();   
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query("INSERT INTO portos (`id_porto`, `id_rota`, `desccricao`, `porto_origem`, `porto_destino`) VALUES (NULL, '{$dados[0]}', '{$dados[1]}', '{$dados[2]}', '{$dados[3]}')");
    }
}

function importaRotaBD($objeto){
    $db = conect();   
    while(($dados = fgetcsv($objeto,1000,";")) !== FALSE){
        $db->query("INSERT INTO rota (`id_rota`, `IMO`,`descricao`, `datetimerota`, `t_inicio`, `t_fim`) VALUES (NULL, '{$dados[0]}', '{$dados[1]}', '{$dados[2]}', '{$dados[3]}', '{$dados[4]}')");
    }
}

try {
    upload('tipoCarga');
    upload('navio');
    upload('rota');
    upload('portos');
    upload('atracacao');
    upload('operacao');
} catch (\Throwable $th) {
    throw $th;
}
header("Location: /trabalho_TCC/Grafico_gantt/index.php");

?>

