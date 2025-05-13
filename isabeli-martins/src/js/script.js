const dias = document.getElementById ('dias');
const primeiroDia = new Date(2025, 4, 1); // Maio é mês 4 (0-11)
const ultimoDia = new Date(2025, 4 + 1, 0).getDate(); // Último dia do mês
const comecaEm = primeiroDia.getDay(); // 0 = domingo, 1 = segunda, etc.

// Espaços vazios antes do 1º dia
for (let i = 0; i < comecaEm; i++) {
    dias.innerHTML += `<div></div>`;
}

// Dias do mês
for (let dia = 1; dia <= ultimoDia; dia++) {
    const classe = dia === 18 ? 'romantico' : '';
    dias.innerHTML += `<div class="${classe}">${dia}</div>`;
}