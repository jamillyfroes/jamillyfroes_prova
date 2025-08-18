function validarUsuario() {
    let nome = document.getElementById("nome").value.trim();
    let email = document.getElementById("email").value.trim();
    let senha = document.getElementById("senha").value;
    let perfil = document.getElementById("id_perfil").value;

    if (nome === "") {
        alert("O campo nome deve ser preenchido!");
        document.getElementById("nome").focus();
        return false;
    }

    if (nome.length < 3) {
        alert("O nome deve ter pelo menos 3 caracteres.");
        document.getElementById("nome").focus();
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        document.getElementById("email").focus();
        return false;
    }

    if (senha.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres.");
        document.getElementById("senha").focus();
        return false;
    }

    if (!perfil) {
        alert("Selecione um perfil.");
        document.getElementById("id_perfil").focus();
        return false;
    }

    return true;
}
