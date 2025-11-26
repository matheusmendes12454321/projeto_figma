<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexao = new mysqli('localhost', 'root', '', 'oi');
if($conexao->connect_error){
    die("Erro de conexão: " . $conexao->connect_error);
}

$nome = $conexao->real_escape_string($_POST['nome']);
$email = $conexao->real_escape_string($_POST['email']);
$telefone = $conexao->real_escape_string($_POST['telefone']);
$nascimento = $conexao->real_escape_string($_POST['nascimento']);
$cpf = $conexao->real_escape_string($_POST['CPF']);
$sexo = $conexao->real_escape_string($_POST['sexo']);
$senha = $conexao->real_escape_string($_POST['senha']);
$rua = $conexao->real_escape_string($_POST['rua']);
$bairro = $conexao->real_escape_string($_POST['bairro']);
$numero_endereco = $conexao->real_escape_string($_POST['numero']);
$cidade = $conexao->real_escape_string($_POST['cidade']);
$pais = $conexao->real_escape_string($_POST['pais']);
$cabelo = $conexao->real_escape_string($_POST['cordecabelo']);
$olho = $conexao->real_escape_string($_POST['cordoolho']);
$pele = $conexao->real_escape_string($_POST['cordepele']);
$altura = $conexao->real_escape_string($_POST['altura']);
$peso = $conexao->real_escape_string($_POST['peso']);
$cor = $conexao->real_escape_string($_POST['corpreferida']);
$tipo_conta = $conexao->real_escape_string($_POST['tipo_conta']);
$tipo_chave = $conexao->real_escape_string($_POST['tipo_chave']);
$chave_pix = $conexao->real_escape_string($_POST[$tipo_chave]);

$verificar = $conexao->query("SELECT id FROM usuarios WHERE cpf = '$cpf' OR email = '$email'");
if($verificar->num_rows > 0){
    echo "<script>alert('CPF ou email já cadastrados!'); window.location.href = '../Paginas/cadastro.html';</script>";
    $conexao->close();
    exit;
}

$conexao->begin_transaction();

try {
    $sql_usuario = "INSERT INTO usuarios (nome, email, telefone, data_nascimento, cpf, sexo, senha) 
                    VALUES ('$nome', '$email', '$telefone', '$nascimento', '$cpf', '$sexo', '$senha')";
    
    if(!$conexao->query($sql_usuario)) {
        throw new Exception("Erro ao inserir usuário: " . $conexao->error);
    }
    
    $id_usuario = $conexao->insert_id;
    
    $sql_endereco = "INSERT INTO enderecos (id_usuario, rua, bairro, numero, cidade, pais) 
                     VALUES ('$id_usuario', '$rua', '$bairro', '$numero_endereco', '$cidade', '$pais')";
    
    if(!$conexao->query($sql_endereco)) {
        throw new Exception("Erro ao inserir endereço: " . $conexao->error);
    }
    
    $sql_biometria = "INSERT INTO biometria (id_usuario, cor_cabelo, cor_olho, cor_pele, altura, peso, cor_preferida) 
                      VALUES ('$id_usuario', '$cabelo', '$olho', '$pele', '$altura', '$peso', '$cor')";
    
    if(!$conexao->query($sql_biometria)) {
        throw new Exception("Erro ao inserir biometria: " . $conexao->error);
    }
    
    $numero_conta = mt_rand(10000, 99999) . '-' . $id_usuario;
    $sql_conta = "INSERT INTO contas (id_usuario, numero_conta, tipo_conta, tipo_chave_pix, chave_pix) 
                  VALUES ('$id_usuario', '$numero_conta', '$tipo_conta', '$tipo_chave', '$chave_pix')";
    
    if(!$conexao->query($sql_conta)) {
        throw new Exception("Erro ao inserir conta: " . $conexao->error);
    }
    
    $id_conta = $conexao->insert_id;
    
    // Commit da transação
    $conexao->commit();
    
    // Configurar sessão
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['id_conta'] = $id_conta;
    $_SESSION['numero_conta'] = $numero_conta;
    $_SESSION['nome_usuario'] = $nome;
    
    echo "<script>alert('Cadastro realizado com sucesso! Sua conta é: $numero_conta'); window.location.href = '../Paginas/banco.php';</script>";
    
} catch (Exception $e) {
    // Rollback em caso de erro
    $conexao->rollback();
    echo "<script>alert('Erro no cadastro: " . $e->getMessage() . "'); window.location.href = '../Paginas/cadastro.html';</script>";
}

$conexao->close();
?>