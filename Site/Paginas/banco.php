<?php
session_start();

if(!isset($_SESSION["id_usuario"])) {
  //header("Location: ./cadastro.html");
  echo "<script>alert('Usuario nao encontrado'); window.location.href = './cadastro.html'</script>";
  exit;
}

$conexao = new mysqli('localhost', 'root', '', 'banco');
if ($conexao->connect_error) {
    die("Error : " . $conexao->connect_error);
}

$id = $_SESSION["id_usuario"];
$busca = mysqli_query($conexao, "SELECT * FROM usuarios JOIN contas ON contas.id_usuario = usuarios.id JOIN enderecos ON enderecos.id_usuario = usuarios.id WHERE usuarios.id='$id'");

if(mysqli_num_rows($busca) == 0){
  echo "<script> alert('Usuario Não encontrado'); window.location.href = './cadastro.html' </script>";
  exit;
}

$usuario = mysqli_fetch_row($busca);

$nome = $usuario[1];
$email = $usuario[2];
$telefone = $usuario[3];
$nascimento = $usuario[4];
$cpf = $usuario[5];
$senha = $usuario[7];
$numero_conta = $usuario[11];
$agencia = $usuario[12];
$saldo = $usuario[14];
$limite = $usuario[15];
$fatura = $usuario[16];
$tipo_chave = $usuario[17];
$chave = $usuario[18];

print_r($usuario)
//echo "<script> console.log($usuario) </script>";

?>    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
  <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
  <h2>Saldo atual: R$ <?php echo $saldo; ?></h2>

  <form action="operacoes.php" method="post">
     <h3>Depósito</h3>
    Valor: <input type="number" step="0.01" name="valor" required>
    <input type="hidden" name="acao" value="deposito">
    <button type="submit">Depositar</button>
  </form>

    <form action="operacoes.php" method="post">
    <h3>Saque</h3>
    Valor: <input type="number" step="0.01" name="valor" required>
    <input type="hidden" name="acao" value="saque">
    <button type="submit">Sacar</button>

  </form>
  <form action="operacoes.php" method="post">
    <h3>Transferência</h3>
    Email do destinatário: <input type="email" name="destinatario" required><br>
    Valor: <input type="number" step="0.01" name="valor" required>
    <input type="hidden" name="acao" value="transferencia">
    <button type="submit">Transferir</button>
  </form>

</body>
</html>