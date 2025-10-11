<?php
session_start();
$usuario = $_SESSION['id_usuario'];
$valor = $_POST['valor']; 
$senha = $_POST['senha'];

$conexao = new mysqli('localhost', 'root', '', 'banco');
if($conexao -> connect_error){
    die($conexao -> connect_error);
}

$confirmacao = mysqli_query($conexao, "SELECT saldo FROM contas JOIN usuarios ON contas.id_usuario = usuarios.id WHERE usuarios.id = '$usuario' AND usuarios.senha = '$senha'");

if(mysqli_num_rows($confirmacao) == 0){
    echo "<script>alert('Senha incorreta'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

$saldo = mysqli_fetch_row($confirmacao)[0];

$saldo_final = $saldo + $valor;

mysqli_query($conexao, "UPDATE contas SET saldo='$saldo_final' WHERE id_usuario='$usuario'");
header("Location: ../Paginas/banco.php");
exit;


?>