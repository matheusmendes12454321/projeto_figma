const tipoPix = document.getElementById("tipo_pix");
const inputEmail = document.getElementById("email");
const inputCpf = document.getElementById("cpf");
const inputAleatorio = document.getElementById("aleatorio");
const btnLogout = document.getElementById("btn-logout");

btnLogout.addEventListener('click', () => {
    document.getElementById("comandos").innerHTML = "<?php logout(); ?>"
})
alert("j")
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