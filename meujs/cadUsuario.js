// meujs/valida.js
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        let nome = document.getElementById("nome").value.trim();
        let email = document.getElementById("email").value.trim();
        let senha = document.getElementById("senha").value;
        let perfil = document.getElementById("id_perfil").value;

        // valida nome
        if (nome === "") {
            alert("O campo Nome deve ser preenchido!");
            document.getElementById("nome").focus();
            event.preventDefault();
            return;
        }

        if (nome.length < 3) {
            alert("O nome deve ter pelo menos 3 caracteres.");
            document.getElementById("nome").focus();
            event.preventDefault();
            return;
        }

        // valida email com regex simples
        let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexEmail.test(email)) {
            alert("Digite um e-mail válido.");
            document.getElementById("email").focus();
            event.preventDefault();
            return;
        }

        // valida senha
        if (senha.length < 8) {
            alert("A senha deve ter pelo menos 8 caracteres.");
            document.getElementById("senha").focus();
            event.preventDefault();
            return;
        }

        // valida perfil
        if (perfil === "") {
            alert("Selecione um perfil.");
            document.getElementById("id_perfil").focus();
            event.preventDefault();
            return;
        }
    });
});

