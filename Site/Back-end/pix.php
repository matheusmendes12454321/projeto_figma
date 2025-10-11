<?php
session_start();

$usuario = $_SESSION['id_usuario'];
$senha = $_POST['senha'];
$chave_destinatario = $_POST['chave_destinatario'];
$tipo_destinatario = $_POST['tipo_pix'];
$valor = $_POST['valor'];


$conexao = new mysqli('localhost', 'root', '', 'banco');
if($conexao -> connect_error){
    die($conexao -> connect_error);
}

$confirmacao_origem = mysqli_query($conexao, "SELECT saldo FROM contas JOIN usuarios ON contas.id_usuario = usuarios.id WHERE usuarios.id = '$usuario' AND usuarios.senha = '$senha'");

$confirmacao_destino = mysqli_query($conexao, "SELECT saldo, tipo_chave_pix, chave_pix FROM contas WHERE tipo_chave_pix = '$tipo_destinatario' AND chave_pix = '$chave_destinatario'");

if(mysqli_num_rows($confirmacao_origem) == 0){
    echo "<script>alert('Senha incorreta'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

if(mysqli_num_rows($confirmacao_destino) == 0){
    echo "<script>alert('Destinatario não encontrado'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

$saldo_origem = mysqli_fetch_row($confirmacao_origem)[0];
$saldo_destino = mysqli_fetch_row($confirmacao_destino)[0];

$saldo_final_origem = $saldo_origem - $valor;
$saldo_final_destino = $saldo_destino + $valor;

if($saldo_final_origem < 0){
    echo "<script>alert('Saldo Insuficiente'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

mysqli_query($conexao, "UPDATE contas SET saldo='$saldo_final_origem' WHERE id_usuario='$usuario'");
mysqli_query($conexao, "UPDATE contas SET saldo='$saldo_final_destino' WHERE tipo_chave_pix = '$tipo_destinatario' AND chave_pix = '$chave_destinatario'");

header("Location: ../Paginas/banco.php");
exit;
?>