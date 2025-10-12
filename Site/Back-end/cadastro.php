<?php
session_start();

$conexao = new mysqli('localhost', 'root', '', 'banco');
if($conexao -> connect_error){
    die($conexao -> connect_error);
}


if(!dados($conexao)){
    excluir($conexao);
    die("Erro no cadastramento dos dados pessoais");
}
if(!endereco($conexao)){
    excluir($conexao);
    die("Erro no cadastramento do endereço");
}
if(!biometria($conexao)){
    excluir($conexao);
    die("Erro no cadastramento da biometria");
}
if(!conta($conexao)){
    excluir($conexao);
    die("Erro no criamento da conta");
}

header("Location: ../Paginas/banco.php");

mysqli_close($conexao);

function dados($conexao){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['CPF'];
    $sexo = $_POST['sexo'];
    $senha = $_POST['senha'];

    $sucesso = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, telefone, data_nascimento, cpf, sexo, senha) VALUES ('$nome', '$email', '$telefone', '$nascimento', '$cpf', '$sexo', '$senha')");

    if(!$sucesso){
        return false;
    }

    $pesquisa = mysqli_query($conexao, "SELECT * from usuarios where cpf = '$cpf' AND email = '$email' AND senha = '$senha'");
    
    $_SESSION['id_usuario'] = mysqli_fetch_row($pesquisa)[0];
    return true;
}


function endereco($conexao){
    $id_usuario = $_SESSION['id_usuario'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $pais = $_POST['pais'];

    $sucesso = mysqli_query($conexao, "INSERT INTO enderecos(id_usuario, rua, bairro, numero, cidade, pais) VALUES ('$id_usuario', '$rua', '$bairro', '$numero', '$cidade', '$pais')");

    if(!$sucesso){
        return false;
    }
    return true;
}

function biometria($conexao){
    $id_usuario = $_SESSION['id_usuario'];
    $cabelo = $_POST['cordecabelo'];
    $olho = $_POST['cordoolho'];
    $pele = $_POST['cordepele'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $cor = $_POST['corpreferida'];

    $sucesso = mysqli_query($conexao, "INSERT INTO biometria(id_usuario, cor_cabelo, cor_olho, cor_pele, altura, peso, cor_preferida) VALUES ('$id_usuario', '$cabelo', '$olho', '$pele', '$altura', '$peso', '$cor')");

    if(!$sucesso){
        return false;
    }
    return true;
}

function conta($conexao){
    $id_usuario = $_SESSION['id_usuario'];
    $numero = (mt_rand(10000, 99999) . '-' . $id_usuario);
    $agencia = mt_rand(1000, 9999);
    $tipo_conta = $_POST['tipo_conta'];
    $tipo_chave = $_POST['tipo_chave'];
    $chave_pix = $_POST[$tipo_chave];
    
    $sucesso = mysqli_query($conexao, "INSERT INTO contas(id_usuario, numero_conta, agencia, tipo_conta, tipo_chave_pix, chave_pix) VALUES ('$id_usuario', '$numero', '$agencia', '$tipo_conta', '$tipo_chave', '$chave_pix')");

    if(!$sucesso){
        return false;
    }
    $_SESSION['id_conta'] = mysqli_fetch_row($sucesso)[0];
    return true;
}

function excluir($conexao){
    $id_usuario = $_SESSION['id_usuario'];
    mysqli_query($conexao, "DELETE FROM usuarios WHERE id = $id_usuario");
    mysqli_query($conexao, "DELETE FROM enderecos WHERE id = $id_usuario");
    mysqli_query($conexao, "DELETE FROM biometria WHERE id = $id_usuario");
    mysqli_query($conexao, "DELETE FROM contas WHERE id = $id_usuario");
    $_SESSION['id_usuario'] = "";
}

?>

