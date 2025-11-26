// Alternar para Cadastro
function goToCadastro() {
    document.getElementById("loginForm").classList.remove("active");
    document.getElementById("cadastroForm").classList.add("active");
}

// Alternar para Login
function goToLogin() {
    document.getElementById("cadastroForm").classList.remove("active");
    document.getElementById("loginForm").classList.add("active");
}

// Cadastro (Armazena no LocalStorage)
function cadastro() {
    let nome = document.getElementById("cadNome").value;
    let email = document.getElementById("cadEmail").value;
    let senha = document.getElementById("cadSenha").value;

    if (!nome || !email || !senha) {
        alert("Preencha todos os campos!");
        return;
    }

    localStorage.setItem("usuarioEmail", email);
    localStorage.setItem("usuarioSenha", senha);
    localStorage.setItem("usuarioNome", nome);

    alert("Conta criada com sucesso!");
    goToLogin();
}

// Login (Verifica LocalStorage)
function login() {
    let email = document.getElementById("loginEmail").value;
    let senha = document.getElementById("loginSenha").value;

    let emailSalvo = localStorage.getItem("usuarioEmail");
    let senhaSalva = localStorage.getItem("usuarioSenha");

    if (email === emailSalvo && senha === senhaSalva) {
        alert("Login realizado com sucesso!");
        window.location.href = "dashboard.html"; // opcional
    } else {
        alert("E-mail ou senha incorretos!");
    }
}
