<?php
session_start();
include '../Back-end/transacoes.php';

if(!isset($_SESSION["id_usuario"])) {
  echo "<script>alert('Usuário não encontrado'); window.location.href = './cadastro.html'</script>";
  exit;
}

$conexao = new mysqli('localhost', 'root', '', 'oi');
if ($conexao->connect_error) {
    die("Error: " . $conexao->connect_error);
}

$id = $_SESSION["id_usuario"];
$id_conta = $_SESSION['id_conta'];

$busca = mysqli_query($conexao, "SELECT 
    c.saldo,
    u.nome, 
    u.email,
    u.telefone, 
    u.data_nascimento, 
    u.cpf, 
    u.senha, 
    c.numero_conta,
    c.agencia, 
    c.limite, 
    c.fatura_atual, 
    c.tipo_chave_pix, 
    c.chave_pix,
    c.tipo_conta
FROM usuarios u
JOIN contas c ON c.id_usuario = u.id 
WHERE u.id = '$id'");

if(mysqli_num_rows($busca) == 0){
  echo "<script>alert('Usuário não encontrado'); window.location.href = './cadastro.html'</script>";
  exit;
}

$usuario = mysqli_fetch_row($busca);

$saldo = $usuario[0];      
$nome = $usuario[1];        
$email = $usuario[2];      
$telefone = $usuario[3];   
$nascimento = $usuario[4];   
$cpf = $usuario[5];        
$senha = $usuario[6];        
$numero_conta = $usuario[7];
$agencia = $usuario[8];     
$limite = $usuario[9];      
$fatura = $usuario[10];    
$tipo_chave = $usuario[11];  
$chave = $usuario[12];      
$tipo_conta = $usuario[13]; 

echo "<!-- DEBUG: Saldo = $saldo, Nome = $nome -->";

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
    <title>Banco Jonas - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../Css/banco.css">
</head> 
<body>
    <header>
        <div class="container">
            <div class="cabecalho">
                <div class="usuario">
                    <h1>Olá, <?php echo $nome; ?>!</h1>
                    <div class="info-conta">
                        <div class="item-conta">
                            <div>Agência</div>
                            <div><?php echo $agencia; ?></div>
                        </div>
                        <div class="item-conta">
                            <div>Conta</div>
                            <div><?php echo $numero_conta; ?></div>
                        </div>
                        <div class="item-conta">
                            <div>Tipo</div>
                            <div><?php echo ucfirst($tipo_conta); ?></div>
                        </div>
                    </div>
                </div>
                <button class="botao-sair" onclick="sair()">
                         <i class="fas fa-sign-out-alt"></i>
                         Sair
                </button>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="dashboard">
            <div class="cartao">
                <div class="saldo-titulo">
                    <div>Saldo Disponível</div>
                    <div><i class="fas fa-eye" onclick="alternarSaldo()" style="cursor:pointer;"></i></div>
                </div>
                <div class="valor-saldo" id="valor-saldo">R$ <?php echo number_format(floatval($saldo), 2, ',', '.'); ?></div>
                <div class="detalhes-saldo">
                    <div>
                        <div style="color:#B3B3B3; font-size:0.9rem;">Limite Disponível</div>
                        <div style="font-weight:600;">R$ <?php echo number_format(floatval($limite), 2, ',', '.'); ?></div>
                    </div>
                    <div>
                        <div style="color:#B3B3B3; font-size:0.9rem;">Fatura Atual</div>
                        <div style="font-weight:600;">R$ <?php echo number_format(floatval($fatura), 2, ',', '.'); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="cartao">
                <h2 style="margin-bottom:20px;">Ações Rápidas</h2>
                <div class="acoes-rapidas">
                    <button class="botao-acao" onclick="mostrarPagamento()">
                        <i class="fas fa-barcode" style="font-size:1.5rem; margin-bottom:8px;"></i>
                        <div>Pagar</div>
                    </button>
                    <button class="botao-acao" onclick="mostrarRecarga()">
                        <i class="fas fa-mobile-alt" style="font-size:1.5rem; margin-bottom:8px;"></i>
                        <div>Recarga</div>
                    </button>
                    <button class="botao-acao" onclick="mostrarEmprestimo()">
                        <i class="fas fa-hand-holding-usd" style="font-size:1.5rem; margin-bottom:8px;"></i>
                        <div>Empréstimo</div>
                    </button>
                    <button class="botao-acao" onclick="mostrarInvestimento()">
                        <i class="fas fa-piggy-bank" style="font-size:1.5rem; margin-bottom:8px;"></i>
                        <div>Investir</div>
                    </button>
                </div>
            </div>
        </section>

        <section class="operacoes">
            <h2 style="margin-bottom:20px;">Operações Bancárias</h2>
            <div class="cartoes">
                <div class="cartao-operacao">
                    <div class="cabecalho-cartao">
                        <div class="icone-cartao">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <h3>Depósito</h3>
                    </div>
                    <form action="../Back-end/deposito.php" method="post">
                        <input type="number" step="0.01" name="valor" placeholder="Valor R$" required>
                        <input type="password" name="senha" placeholder="Sua Senha" required>
                        <input type="hidden" name="acao" value="deposito">
                        <button type="submit" class="botao botao-deposito">Depositar</button>
                    </form>
                </div>

                <div class="cartao-operacao">
                    <div class="cabecalho-cartao">
                        <div class="icone-cartao">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <h3>Saque</h3>
                    </div>
                    <form action="../Back-end/saque.php" method="post">
                        <input type="number" step="0.01" name="valor" placeholder="Valor R$" required>
                        <input type="password" name="senha" placeholder="Sua Senha" required>
                        <input type="hidden" name="acao" value="saque">
                        <button type="submit" class="botao botao-saque">Sacar</button>
                    </form>
                </div>

                <div class="cartao-operacao">
                    <div class="cabecalho-cartao">
                        <div class="icone-cartao">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3>PIX</h3>
                    </div>
                    <form action="../Back-end/pix.php" method="post">
                        <select name="tipo_pix" required onchange="mostrarCampoPix()">
                            <option value="" disabled selected>Tipo de PIX</option>
                            <option value="email">Email</option>
                            <option value="cpf">CPF</option>
                            <option value="telefone">Telefone</option>
                        </select>
                        <input type="text" name="chave_destinatario" placeholder="Chave do destinatário" required>
                        <input type="number" step="0.01" name="valor" placeholder="Valor R$" required>
                        <input type="password" name="senha" placeholder="Sua Senha" required>
                        <input type="hidden" name="acao" value="transferencia">
                        <button type="submit" class="botao botao-pix">Transferir</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="transacoes">
            <h2 style="margin-bottom:20px;">Últimas Transações</h2>
            <div class="lista-transacoes" id="lista-transacoes">
                <?php 
                if (function_exists('buscarTransacoes')) {
                    buscarTransacoes($id_conta);
                }
                ?>
            </div>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>Banco Jonas &copy; 2024 - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
    let saldoVisivel = true;

    function alternarSaldo() {
        const elementoSaldo = document.getElementById('valor-saldo');
        const icone = document.querySelector('.fa-eye');
        
        if (saldoVisivel) {
            elementoSaldo.textContent = 'R$ ••••••••';
            icone.classList.remove('fa-eye');
            icone.classList.add('fa-eye-slash');
        } else {
            elementoSaldo.textContent = 'R$ <?php echo number_format(floatval($saldo), 2, ',', '.'); ?>';
            icone.classList.remove('fa-eye-slash');
            icone.classList.add('fa-eye');
        }
        saldoVisivel = !saldoVisivel;
    }

    function mostrarCampoPix() {
        const tipoPix = document.querySelector('select[name="tipo_pix"]').value;
        const campoChave = document.querySelector('input[name="chave_destinatario"]');
        
        switch(tipoPix) {
            case 'email':
                campoChave.placeholder = 'Digite o email';
                break;
            case 'cpf':
                campoChave.placeholder = 'Digite o CPF';
                break;
            case 'telefone':
                campoChave.placeholder = 'Digite o telefone';
                break;
        }
    }

    function sair() {
    if(confirm('Deseja realmente sair?')) {
        
        window.location.href = '../Paginas/index.html';
    }

    }
    function mostrarPagamento() { alert('Funcionalidade em desenvolvimento!'); }
    function mostrarRecarga() { alert('Funcionalidade em desenvolvimento!'); }
    function mostrarEmprestimo() { alert('Funcionalidade em desenvolvimento!'); }
    function mostrarInvestimento() { alert('Funcionalidade em desenvolvimento!'); }
    </script>
</body>
</html>