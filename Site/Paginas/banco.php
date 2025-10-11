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

print_r($usuario);
//echo "<script> console.log($usuario) </script>";

function logout(){
  $_SESSION["id_usuario"] = "";
  header('Location: ./index.html');
  exit;
}

?>    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../Css/banco.css">
</head>
<body>
  <p id="comandos"></p>
  <header>
    <div class="container">
      <div class="header-content">
          <div class="user-info">
              <h1>Olá, <?php echo $nome; ?>!</h1>
              <div class="account-info">
                  <div class="account-item">
                      <span class="account-label">Agência</span>
                      <span class="account-value">0001</span>
                  </div>
                  <div class="account-item">
                      <span class="account-label">Conta</span>
                      <span class="account-value">123456-7</span>
                  </div>
                  <div class="account-item">
                      <span class="account-label">Tipo</span>
                      <span class="account-value">Corrente</span>
                  </div>
              </div>
          </div>
          <button class="btn-logout">
              <i class="fas fa-sign-out-alt"></i>
              Sair
          </button>
      </div>
    </div>
  </header>

  <div class="container">
      <section class="dashboard">
          <div class="balance-card">
              <div class="balance-header">
                  <div class="balance-title">Saldo Disponível</div>
                  <div class="balance-actions">
                      <i class="fas fa-eye"></i>
                  </div>
              </div>
              <div class="balance-amount">R$ <?php echo $saldo; ?></div>
              <div class="balance-details">
                  <div class="balance-detail">
                      <span class="detail-label">Limite Disponível</span>
                      <span class="detail-value">R$ 2.500,00</span>
                  </div>
                  <div class="balance-detail">
                      <span class="detail-label">Investimentos</span>
                      <span class="detail-value">R$ 12.340,50</span>
                  </div>
              </div>
          </div>
          
          <div class="quick-actions">
              <h2 class="section-title">Ações Rápidas</h2>
              <div class="action-buttons">
                  <button class="action-btn">
                      <div class="action-icon">
                          <i class="fas fa-barcode"></i>
                      </div>
                      <div class="action-label">Pagar</div>
                  </button>
                  <button class="action-btn">
                      <div class="action-icon">
                          <i class="fas fa-mobile-alt"></i>
                      </div>
                      <div class="action-label">Recarga</div>
                  </button>
                  <button class="action-btn">
                      <div class="action-icon">
                          <i class="fas fa-hand-holding-usd"></i>
                      </div>
                      <div class="action-label">Empréstimo</div>
                  </button>
                  <button class="action-btn">
                      <div class="action-icon">
                          <i class="fas fa-piggy-bank"></i>
                      </div>
                      <div class="action-label">Investir</div>
                  </button>
              </div>
          </div>
      </section>

      <section class="operations">
          <h2 class="section-title">Operações Bancárias</h2>
          <div class="cards">
              <div class="card">
                  <div class="card-header">
                      <div class="card-icon">
                          <i class="fas fa-arrow-down"></i>
                      </div>
                      <h3>Depósito</h3>
                  </div>
                  <form action="../Back-end/deposito.php" method="post">
                      <input type="number" step="0.01" name="valor" placeholder="Valor" required>
                      <input type="password" name="senha" id="" placeholder="Senha">
                      <input type="hidden" name="acao" value="deposito">
                      <button type="submit" class="btn">Depositar</button>
                  </form>
              </div>

              <div class="card">
                  <div class="card-header">
                      <div class="card-icon">
                          <i class="fas fa-arrow-up"></i>
                      </div>
                      <h3>Saque</h3>
                  </div>
                  <form action="operacoes.php" method="post">
                      <input type="number" step="0.01" name="valor" placeholder="Valor" required>
                      <input type="hidden" name="acao" value="saque">
                      <button type="submit" class="btn">Sacar</button>
                  </form>
              </div>

              <div class="card">
                  <div class="card-header">
                      <div class="card-icon">
                          <i class="fas fa-exchange-alt"></i>
                      </div>
                      <h3>Transferência</h3>
                  </div>
                  <form action="operacoes.php" method="post">
                      <label for="tipo_pix">Tipo de transferência:</label>
                      <select name="tipo_pix" id="tipo_pix" required>
                          <option value="" disabled selected>Selecione</option>
                          <option value="Email">Email</option>
                          <option value="CPF">CPF</option>
                          <option value="Aleatorio">Aleatório</option>
                      </select>

                      <input type="email" id="email" name="destinatario_email" placeholder="Email do destinatário">
                      <input type="text" id="cpf" name="destinatario_cpf" placeholder="CPF do destinatário">
                      <input type="text" id="aleatorio" name="destinatario_aleatorio" placeholder="Chave aleatória">

                      <input type="number" step="0.01" name="valor" placeholder="Valor" required>
                      <input type="hidden" name="acao" value="transferencia">
                      <button type="submit" class="btn">Transferir</button>
                  </form>
              </div>
          </div>
      </section>

      <section class="transactions">
          <h2 class="section-title">Últimas Transações</h2>
          <div class="transaction-list">
              <div class="transaction-item">
                  <div class="transaction-info">
                      <div class="transaction-icon">
                          <i class="fas fa-arrow-down"></i>
                      </div>
                      <div class="transaction-details">
                          <div class="transaction-title">Depósito Recebido</div>
                          <div class="transaction-date">15/05/2023 - 10:30</div>
                      </div>
                  </div>
                  <div class="transaction-amount positive">-</div>
              </div>
              
              <div class="transaction-item">
                  <div class="transaction-info">
                      <div class="transaction-icon">
                          <i class="fas fa-shopping-cart"></i>
                      </div>
                      <div class="transaction-details">
                          <div class="transaction-title">Supermercado</div>
                          <div class="transaction-date">14/05/2023 - 16:45</div>
                      </div>
                  </div>
                  <div class="transaction-amount negative">-</div>
              </div>
              
              <div class="transaction-item">
                  <div class="transaction-info">
                      <div class="transaction-icon">
                          <i class="fas fa-exchange-alt"></i>
                      </div>
                      <div class="transaction-details">
                          <div class="transaction-title">Transferência Enviada</div>
                          <div class="transaction-date">13/05/2023 - 09:15</div>
                      </div>
                  </div>
                  <div class="transaction-amount negative">-</div>
              </div>
              
              <div class="transaction-item">
                  <div class="transaction-info">
                      <div class="transaction-icon">
                          <i class="fas fa-arrow-up"></i>
                      </div>
                      <div class="transaction-details">
                          <div class="transaction-title">Saque</div>
                          <div class="transaction-date">12/05/2023 - 14:20</div>
                      </div>
                  </div>
                  <div class="transaction-amount negative">-</div>
              </div>
          </div>
      </section>
  </div>

  <footer>
      <div class="container">
          <p>bancojonas &copy; 2023 - Todos os direitos reservados</p>
      </div>
  </footer>

</body>
</html>

<script>
const tipoPix = document.getElementById("tipo_pix");
const inputEmail = document.getElementById("email");
const inputCpf = document.getElementById("cpf");
const inputAleatorio = document.getElementById("aleatorio");
const btnLogout = document.getElementById("btn-logout");


tipoPix.addEventListener("change", function() {
    inputEmail.style.display = "none";
    inputCpf.style.display = "none";
    inputAleatorio.style.display = "none";

    if (this.value === "Email") {
        inputEmail.style.display = "block";
    } else if (this.value === "CPF") {
        inputCpf.style.display = "block";
    } else if (this.value === "Aleatorio") {
        inputAleatorio.style.display = "block";
    }
});
</script>