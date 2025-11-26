<?php
session_start();
include 'transacoes.php';

$usuario = $_SESSION['id_usuario'];
$conta = $_SESSION['id_conta'];
$valor = $_POST['valor']; 
$senha = $_POST['senha'];


$conexao = new mysqli('localhost', 'root', '', 'oi');
if($conexao -> connect_error){
    die($conexao -> connect_error);
}

$confirmacao = mysqli_query($conexao, "SELECT saldo, nome FROM contas JOIN usuarios ON contas.id_usuario = usuarios.id WHERE usuarios.id = '$usuario' AND usuarios.senha = '$senha'");

if(mysqli_num_rows($confirmacao) == 0){
    echo "<script>alert('Senha incorreta'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

$saldo = mysqli_fetch_row($confirmacao)[0];
$nome = mysqli_fetch_row($confirmacao)[1];
$saldo_final = $saldo + $valor;

mysqli_query($conexao, "UPDATE contas SET saldo='$saldo_final' WHERE id_usuario='$usuario'");

$descricao = "$nome depositou R$ $valor";
adicionarTransacao("deposito", "$descricao", $conta, $conta, $valor);
mysqli_close($conexao);
header("Location: ../Paginas/banco.php");
exit;


?>