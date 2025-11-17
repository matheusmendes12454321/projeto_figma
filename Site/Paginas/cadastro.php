<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Banco Xonas</title>
    <link rel="stylesheet" href="../Css/cadastro.css">
</head>
<body>

<header>
    <div class="logo">Banco Xonas</div>
</header>

<section class="container">
    <div class="card">

        <h2>Cadastro</h2>
        <p class="subtitle">Preencha todos os campos abaixo</p>

        <form action="../Back-end/cadastro.php" method="POST">

            <h3 class="secao">Dados pessoais</h3>

            <div class="input-group">
                <label>Nome completo</label>
                <input type="text" name="nome" required>
            </div>

            <div class="input-group">
                <label>E-mail</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Telefone</label>
                <input type="text" name="telefone" required>
            </div>

            <div class="input-group">
                <label>Data de nascimento</label>
                <input type="date" name="nascimento" required>
            </div>

            <div class="input-group">
                <label>CPF</label>
                <input type="text" name="CPF" required>
            </div>

            <div class="input-group">
                <label>Sexo</label>
                <select name="sexo" required>
                    <option value="">Selecione</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" required>
            </div>

            <h3 class="secao">Endereço</h3>

            <div class="input-group">
                <label>Rua</label>
                <input type="text" name="rua" required>
            </div>

            <div class="input-group">
                <label>Bairro</label>
                <input type="text" name="bairro" required>
            </div>

            <div class="input-group">
                <label>Número</label>
                <input type="text" name="numero" required>
            </div>

            <div class="input-group">
                <label>Cidade</label>
                <input type="text" name="cidade" required>
            </div>

            <div class="input-group">
                <label>País</label>
                <input type="text" name="pais" required>
            </div>

            <h3 class="secao">Características físicas</h3>

            <div class="input-group">
                <label>Cor de cabelo</label>
                <input type="text" name="cordecabelo" required>
            </div>

            <div class="input-group">
                <label>Cor dos olhos</label>
                <input type="text" name="cordoolho" required>
            </div>

            <div class="input-group">
                <label>Cor da pele</label>
                <input type="text" name="cordepele" required>
            </div>

            <div class="input-group">
                <label>Altura (cm)</label>
                <input type="number" name="altura" required>
            </div>

            <div class="input-group">
                <label>Peso (kg)</label>
                <input type="number" name="peso" required>
            </div>

            <div class="input-group">
                <label>Cor preferida</label>
                <input type="text" name="corpreferida" required>
            </div>

            <h3 class="secao">Informações bancárias</h3>

            <div class="input-group">
                <label>Tipo de conta</label>
                <select name="tipo_conta" required>
                    <option value="">Selecione</option>
                    <option value="corrente">Conta Corrente</option>
                    <option value="poupanca">Conta Poupança</option>
                </select>
            </div>

            <div class="input-group">
                <label>Tipo de chave PIX</label>
                <select name="tipo_chave" id="tipo_chave" required onchange="mostrarCampoPix()">
                    <option value="">Selecione</option>
                    <option value="email">E-mail</option>
                    <option value="telefone">Telefone</option>
                    <option value="CPF">CPF</option>
                </select>
            </div>


            <button class="btn" type="submit">Cadastrar</button>

        </form>

    </div>
</section>

<footer>
    <p>© 2025 Banco Xonas</p>
</footer>

<script src="./cadastro.js"></script>
</body>
</html>
