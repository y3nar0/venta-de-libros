const menu = document.getElementById('mostrar-nav')
const mostrar = document.querySelector('nav')

menu.addEventListener('click', () => {
    mostrar.classList.toggle('mostrar')
})