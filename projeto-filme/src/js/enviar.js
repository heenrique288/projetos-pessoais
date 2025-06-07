document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("formVoto");

    form.addEventListener("submit", function(e) {
        e.preventDefault(); // Impede envio normal

        const formData = new FormData(form);
        const filmeSelecionado = formData.get("filme");

        if (!filmeSelecionado) {
            alert("Por favor, selecione um filme para votar.");
            return;
        }

        // Pega o input selecionado
        const inputSelecionado = document.querySelector(`input[name="filme"][value="${filmeSelecionado}"]`);
        const nomeFilme = inputSelecionado.dataset.nome;

        const confirmacao = confirm(`Você tem certeza que deseja votar em ${nomeFilme}?`);
        if (!confirmacao) return;

        fetch("votar.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data.trim());  // Mostra "Voto computado com sucesso!" ou "Você já votou!"
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Ocorreu um erro ao enviar o voto.");
        });
    });
});
