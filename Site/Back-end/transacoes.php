<?php
function adicionarTransacao($tipo, $descricao, $id_destino, $id_origem, $valor){
    $conexao = new mysqli('localhost', 'root', '', 'banco');
    if($conexao -> connect_error){
        die($conexao -> connect_error);
    }

    mysqli_query($conexao, "INSERT INTO transacoes(conta_origem_id, conta_destino_id, tipo, valor, descricao) VALUES ('$id_origem', '$id_destino', '$tipo', '$valor','$descricao')");
    mysqli_close($conexao);
}

function buscarTransacoes($id){
    $conexao = new mysqli('localhost', 'root', '', 'banco');
    if($conexao -> connect_error){
    die($conexao -> connect_error);
    }

    $busca = mysqli_query($conexao, "SELECT * FROM transacoes WHERE conta_origem_id = '$id' OR conta_destino_id = '$id'");

    if(mysqli_num_rows($busca) == 0){
    return null;
    }
    
    $all = [];


    for($i = 0; $i < mysqli_num_rows($busca); $i++){
        /*$origem = mysqli_fetch_row($busca)[1];
        $destino = mysqli_fetch_row($busca)[2];
        $tipo = mysqli_fetch_row($busca)[3];
        $valor = mysqli_fetch_row($busca)[4];
        $descricao = mysqli_fetch_row($busca)[5];
        $data = mysqli_fetch_row($busca)[6];*/
        $all[] = mysqli_fetch_row($busca);
        $origem = $all[0][1];
        $destino = $all[0][2];
        $tipo = $all[0][3];
        $valor = $all[0][4];
        $descricao = $all[0][5];
        $data = $all[0][6];
        $texto = "
            <script>
            let div = document.createElement('div');
            div.className = 'transaction-item';
            div.innerHTML = `
                <div class='transaction-info'>
                    <div class='transaction-icon'>
                        <i class='fas fa-exchange-alt'></i>
                    </div>
                    <div class='transaction-details'>
                        <div class='transaction-title'>$tipo</div>
                        <div class='transaction-date'>$data</div>
                    </div>
                </div>
                <div class='transaction-amount $tipo'>$valor</div>
            `;
            document.getElementById('transacoes').appendChild(div)
            </script>
        ";
        echo "<script>criar('$tipo','$data','$valor')</script>";
        $all = [];
    }

    mysqli_close($conexao);

}
?>