const menu = document.getElementById('mostrar-nav')
const mostrar = document.querySelector('nav')

menu.addEventListener('click', () => {
    mostrar.classList.toggle('mostrar')
})



const liga1 = document.getElementById('oculto-e')
const liga2 = document.getElementById('oculto-b')

const valorRecibido = document.querySelectorAll('article')
valorRecibido.forEach(elemento => {
    elemento.addEventListener('click', () =>{
        liga1.setAttribute('value',elemento.getAttribute('value'))
        liga2.setAttribute('value',elemento.getAttribute('value'))
    })
})


