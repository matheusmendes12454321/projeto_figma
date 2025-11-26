<?php
session_start();
include 'transacoes.php';

if(!isset($_SESSION["id_usuario"])) {
    echo "<script>alert('Usuário não autenticado'); window.location.href = '../Paginas/cadastro.html'</script>";
    exit;
}

if(!isset($_POST['valor']) || !isset($_POST['senha'])) {
    echo "<script>alert('Dados incompletos'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

$usuario = $_SESSION['id_usuario'];
$conta = $_SESSION['id_conta'];
$valor = floatval($_POST['valor']); 
$senha = $_POST['senha'];

if($valor <= 0) {
    echo "<script>alert('Valor inválido'); window.location.href = '../Paginas/banco.php'</script>";
    exit;
}

$conexao = new mysqli('localhost', 'root', '', 'oi');
if($conexao->connect_error){
    die("Erro de conexão: " . $conexao->connect_error);
}

$confirmacao = mysqli_query($conexao, "SELECT c.saldo, u.nome 
FROM contas c
JOIN usuarios u ON c.id_usuario = u.id 
WHERE u.id = '$usuario' AND u.senha = '$senha'");

if(mysqli_num_rows($confirmacao) == 0){
    echo "<script>alert('Senha incorreta'); window.location.href = '../Paginas/banco.php'</script>";
    mysqli_close($conexao);
    exit;
}

$dados = mysqli_fetch_assoc($confirmacao);
$saldo = floatval($dados['saldo']);
$nome = $dados['nome'];

if($saldo < $valor) {
    echo "<script>alert('Saldo insuficiente. Saldo disponível: R$ " . number_format($saldo, 2, ',', '.') . "'); window.location.href = '../Paginas/banco.php'</script>";
    mysqli_close($conexao);
    exit;
}

$saldo_final = $saldo - $valor;

$update = mysqli_query($conexao, "UPDATE contas SET saldo = '$saldo_final' WHERE id_usuario = '$usuario'");

if(!$update) {
    echo "<script>alert('Erro ao processar saque'); window.location.href = '../Paginas/banco.php'</script>";
    mysqli_close($conexao);
    exit;
}

$descricao = "Saque realizado por $nome - R$ " . number_format($valor, 2, ',', '.');

if(function_exists('adicionarTransacao')) {
    adicionarTransacao($conta, $conta, "saque", $valor, $descricao);
} else {
    mysqli_query($conexao, "INSERT INTO transacoes (conta_origem_id, conta_destino_id, tipo, valor, descricao) 
                           VALUES ('$conta', '$conta', 'saque', '$valor', '$descricao')");
}

mysqli_close($conexao);

echo "<script>alert('Saque realizado com sucesso! Novo saldo: R$ " . number_format($saldo_final, 2, ',', '.') . "'); window.location.href = '../Paginas/banco.php'</script>";
exit;
?>