// ANIMAÇÃO DO CORAÇÃO NO CALENDÁRIO E CONSTRUÇÃO DOS DIAS DE MAIO

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
// FIM

// CÓDIGO PARA EXECUTAR O AUDIO E ESCUTAR A MÚSICA

let audio = document.getElementById('player')
let faixaAtual = null
let faixas = document.querySelectorAll('.faixa')
let indiceAtual = -1

const btnPlay = document.getElementById('btn-play')
const btnAnterior = document.getElementById('btn-anterior')
const btnProximo = document.getElementById('btn-proximo')
const barraProgresso = document.getElementById('barra-progresso')
const tempoAtual = document.getElementById('tempo-atual')
const tempoDuracao = document.getElementById('tempo-duracao')

function formatarTempo(segundos) {
  let min = Math.floor(segundos / 60)
  let seg = Math.floor(segundos % 60)
  return `${min}:${seg < 10 ? '0' + seg : seg}`
}

function atualizarBarra() {
  barraProgresso.value = audio.currentTime
  tempoAtual.textContent = formatarTempo(audio.currentTime)
}

audio.addEventListener('timeupdate', atualizarBarra)

audio.addEventListener('loadedmetadata', () => {
  barraProgresso.max = audio.duration
  tempoDuracao.textContent = formatarTempo(audio.duration)
})

barraProgresso.addEventListener('input', () => {
  audio.currentTime = barraProgresso.value
})

function tocarMusica(faixa, caminho) {
  faixas = document.querySelectorAll('.faixa') // Atualiza faixas se mudar
  indiceAtual = Array.from(faixas).indexOf(faixa)

  if (faixaAtual === faixa && !audio.paused) {
    audio.pause()
    faixa.classList.remove('ativa')
    faixa.querySelector('.titulo').classList.remove('ativa')
    faixa.style.boxShadow = 'none'
    btnPlay.classList.replace('fa-pause', 'fa-play')
    faixaAtual = null
    return
  }

  if (faixaAtual && faixaAtual !== faixa) {
    faixaAtual.classList.remove('ativa')
    faixaAtual.querySelector('.titulo').classList.remove('ativa')
    faixaAtual.style.boxShadow = 'none'
  }

  audio.src = caminho
  audio.play()

  faixa.classList.add('ativa')
  faixa.querySelector('.titulo').classList.add('ativa')
  faixa.style.boxShadow = '0 0 2px white'

  btnPlay.classList.replace('fa-play', 'fa-pause')
  faixaAtual = faixa
}

btnPlay.addEventListener('click', () => {
  if (!audio.src) return
  if (audio.paused) {
    audio.play()
    btnPlay.classList.replace('fa-play', 'fa-pause')
    faixaAtual?.querySelector('.titulo')?.classList.add('ativa')
    faixaAtual?.style.setProperty('box-shadow', '0 0 2px white')
  } else {
    audio.pause()
    btnPlay.classList.replace('fa-pause', 'fa-play')
    faixaAtual?.querySelector('.titulo')?.classList.remove('ativa')
    faixaAtual?.style.setProperty('box-shadow', 'none')
  }
})

btnAnterior.addEventListener('click', () => {
  if (indiceAtual > 0) {
    faixas[indiceAtual - 1].click()
  }
})

btnProximo.addEventListener('click', () => {
  if (indiceAtual < faixas.length - 1) {
    faixas[indiceAtual + 1].click()
  }
})



