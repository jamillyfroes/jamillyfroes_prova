// meujs
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        let nome = document.getElementById("nome").value.trim();
        let endereco = document.getElementById("endereco").value.trim();
        let telefone = document.getElementById("telefone").value.trim();
        let email = document.getElementById("email").value.trim(); 
        let funcionario_responsavel = document.getElementById("id_funcionario_responsavel").value;

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


        //valida endereco
        if (endereco === "") {
            alert("O campo Endereço deve ser preenchido!");
            document.getElementById("endereco").focus();
            event.preventDefault();
            return;
        }

        
        if (endereco.length < 3) {
            alert("O Endereço deve ter pelo menos 3 caracteres.");
            document.getElementById("endereco").focus();
            event.preventDefault();
            return;
        }

         //valida telefone
         if (telefone === "") {
            alert("O campo Telefone deve ser preenchido!");
            document.getElementById("telefone").focus();
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


        // valida funcionario responsavel
        if (funcionario_responsavel === "") {
            alert("Selecione um Funcionario Responsável.");
            document.getElementById("id_funcionario_responsavel").focus();
            event.preventDefault();
            return;
        }
    });
});
