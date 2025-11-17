<?php
session_start();

$conexao = new mysqli('localhost', 'root', '', 'banco');
if($conexao -> connect_error){
    die($conexao -> connect_error);
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nascimento = $_POST['nascimento'];
$cpf = $_POST['CPF'];
$sexo = $_POST['sexo'];
$senha = $_POST['senha'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$pais = $_POST['pais'];
$cabelo = $_POST['cordecabelo'];
$olho = $_POST['cordoolho'];
$pele = $_POST['cordepele'];
$altura = $_POST['altura'];
$peso = $_POST['peso'];
$cor = $_POST['corpreferida'];
$numero = (mt_rand(10000, 99999) . '-' . $id_usuario);
$agencia = mt_rand(1000, 9999);
$tipo_conta = $_POST['tipo_conta'];
$tipo_chave = $_POST['tipo_chave'];
$chave_pix = $_POST[$tipo_chave];

$verificar = mysqli_query($conexao, "SELECT * from usuarios where cpf = '$cpf' OR email = '$email'");
if(mysqli_num_rows($verificar) > 0){
    header("Location: ../Paginas/cadastro.html");
    mysqli_close($conexao);
    exit;
}

$sucessoU = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, telefone, data_nascimento, cpf, sexo, senha) VALUES ('$nome', '$email', '$telefone', '$nascimento', '$cpf', '$sexo', '$senha')");
$sucessoE = mysqli_query($conexao, "INSERT INTO enderecos(id_usuario, rua, bairro, numero, cidade, pais) VALUES ('$id_usuario', '$rua', '$bairro', '$numero', '$cidade', '$pais')");
$sucessoC = mysqli_query($conexao, "INSERT INTO contas(id_usuario, numero_conta, agencia, tipo_conta, tipo_chave_pix, chave_pix) VALUES ('$id_usuario', '$numero', '$agencia', '$tipo_conta', '$tipo_chave', '$chave_pix')");

if(!$sucessoU || !$sucessoE || !$sucessoC){
    header("Location: ../Paginas/cadastro.html");
    mysqli_close($conexao);
    exit;
}

$pesquisa = mysqli_query($conexao, "SELECT * from usuarios where cpf = '$cpf' AND email = '$email' AND senha = '$senha'");
$_SESSION['id_usuario'] = mysqli_fetch_row($pesquisaU)[0];
$_SESSION['id_conta'] = mysqli_fetch_row($sucessoC)[0];

header("Location: ../Paginas/banco.php");
mysqli_close($conexao);
exit;
?>