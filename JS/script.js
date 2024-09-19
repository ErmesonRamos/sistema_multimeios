const addLivro = document.querySelector('#addLivro');


addLivro.addEventListener('click', (event)=> {
  event.preventDefault();
  let tituloLivro = document.querySelector('#ititulo-livro').value;
  let autorLivro = document.querySelector('#iautor').value;
  let generoLivro = document.querySelector('#igenero').value;
  arr = [tituloLivro, autorLivro, generoLivro];
  console.log(arr);
})


