const comprar = document.querySelectorAll('#comprar')
const id_libro = document.querySelectorAll('#id-book')

comprar.forEach(element => {
    element.addEventListener('click', () => {
        console.log(element.getAttribute('value'))
    })
})

// comprar.addEventListener('click', () => {
//     alert('hola')
// })

// const holaMundo = text => alert(text)

// title.addEventListener('click', () => {
//     holaMundo('Los eventos')
//     console.log(event)
    /* tecnicamente event es un objeto que ya existe dentro de cada objeto
       solo que no es 100% estandar con los navegadores
       muestra varios datos del evento */
// })

// document.querySelector('button').addEventListener('click', () => {
//     holaMundo('Saludar')
// })