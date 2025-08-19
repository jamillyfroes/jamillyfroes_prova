
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form[action='processa_alteracao_usuario.php']");

    if (form) {
        form.addEventListener("submit", function (event) {
            let nome = document.getElementById("nome").value.trim();
            let email = document.getElementById("email").value.trim();
            let perfil = document.getElementById("id_perfil").value;
            let novaSenha = document.getElementById("nova_senha") ? document.getElementById("nova_senha").value : "";

            //nome
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

            //email
            let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(email)) {
                alert("Digite um e-mail válido.");
                document.getElementById("email").focus();
                event.preventDefault();
                return;
            }

            //perfil
            if (perfil === "") {
                alert("Selecione um perfil.");
                document.getElementById("id_perfil").focus();
                event.preventDefault();
                return;
            }

            //nova senha (só se o campo for preenchido)
            if (novaSenha.length > 0 && novaSenha.length < 8) {
                alert("A nova senha deve ter pelo menos 8 caracteres.");
                document.getElementById("nova_senha").focus();
                event.preventDefault();
                return;
            }
        });
    }
});
