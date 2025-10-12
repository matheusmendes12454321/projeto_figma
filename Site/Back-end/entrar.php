<?php
session_start();
entrar();

function entrar(){
    $cpf = $_POST['cpf_login'];
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    $conexao = new mysqli('localhost', 'root', '', 'banco');
    if($conexao -> connect_error){
        die($conexao -> connect_error);
    }

    $pesquisa = mysqli_query($conexao, "SELECT * from usuarios where cpf = '$cpf' AND email = '$email' AND senha = '$senha'");
    
    if(mysqli_num_rows($pesquisa) != 1){
        die("usuario nao encontrado");
    }

    $_SESSION['id_usuario'] = mysqli_fetch_row($pesquisa)[0];
    $id = $_SESSION['id_usuario'];

    $busca_conta = mysqli_query($conexao, "SELECT id from contas where id_usuario='$id'");
    $_SESSION['id_conta'] = mysqli_fetch_row($busca_conta)[0];

    

    mysqli_close($conexao);

    header("Location: ../Paginas/banco.php");
}

?>