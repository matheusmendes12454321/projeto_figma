document.getElementById("btn-biometria").addEventListener('click', () => {
    abrirbiometria();
} )
document.getElementById("verificar").addEventListener('click', () => {
    verificar()
})
document.getElementById("usuario_telefone").addEventListener('keydown', function(e){
    if (e.key === ' ') {
        e.preventDefault(); // Impede a digitação do espaço
    }
})


function abrirbiometria() {
let div = document.querySelector(".biometria-oculta");
if (div) {
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
}
}

function verificar(n){
    let fieldsetsVisiveis = document.querySelectorAll('fieldset');
    let v = false;

    let inputs = fieldsetsVisiveis[n].querySelectorAll('input');
    for(let i = 0; i < inputs.length; i++){
        if(inputs[i].value == "" && inputs[i].type != "button"){
            v = true;
            break; 
        }
    }
    
    if(v){
        alert("Preencha todos os campos visíveis");
        return false;
    }
    

    return true;
}


function proximo(n){
    if(!verificar(n)){
        return;
    }

    if(n == 0){
        if(document.getElementById('senha').value != document.getElementById('confirmar_senha').value){
            alert("As senhas não são iguais");
            return;
        }
        if(String(document.getElementById("usuario_email").value).indexOf("@") == -1){
            alert("Verifique se o email digitado está correto")
            return;
        }

        document.getElementById("dados_pessoais").style.display = 'none'
        document.getElementById("endereco").style.display = 'flex'
    }
    if(n == 1){
        document.getElementById("endereco").style.display = 'none'
        document.getElementById("biometria").style.display = 'flex'
    }
    if(n == 2){
        document.getElementById("biometria").style.display = 'none'
        document.getElementById("conta").style.display = 'flex'
    }
}

function voltar(n){
    if(n == 0){
        document.getElementById("dados_pessoais").style.display = 'flex'
        document.getElementById("endereco").style.display = 'none'
    }
    if(n == 1){
        document.getElementById("endereco").style.display = 'flex'
        document.getElementById("biometria").style.display = 'none'
    }
    if(n == 2){
        document.getElementById("biometria").style.display = 'flex'
        document.getElementById("conta").style.display = 'none'
    }
}
