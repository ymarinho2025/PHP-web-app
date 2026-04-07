document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

    // Regex para email
    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Regex para caracteres proibidos
    let invalidCharsRegex = /[()\/\\<>]/;

    // Bloqueia caracteres inválidos no nome
    if (invalidCharsRegex.test(name)) {
        alert("O nome contém caracteres inválidos: ( ) / \\ < >");
        return;
    }

    // Validação do email
    if (!emailRegex.test(email)) {
        alert("Digite um email válido.");
        return;
    }

    // Bloqueia caracteres inválidos no email
    if (invalidCharsRegex.test(email)) {
        alert("O email contém caracteres inválidos: ( ) / \\ < >");
        return;
    }

    // Tamanho mínimo da senha
    if (password.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres.");
        return;
    }

    // Bloqueia caracteres inválidos na senha
    if (invalidCharsRegex.test(password)) {
        alert("A senha contém caracteres inválidos: ( ) / \\ < >");
        return;
    }

    // Se tudo estiver certo, envia o formulário
    this.submit();
});