const addLivro = document.querySelector('#addLivro');
const taskList = document.querySelector('#task-list');

addLivro.addEventListener('click', (event) => {
  event.preventDefault();
  
  let tituloLivro = document.querySelector('#ititulo-livro').value;
  let autorLivro = document.querySelector('#iautor').value;
  let generoLivro = document.querySelector('#igenero').value;

  const livro = {
    titulo: tituloLivro,
    autor: autorLivro,
    genero: generoLivro
  };

  const taskListItem = document.createElement('li');
  taskListItem.classList.add('task-box', 'template');

  const taskTitle = document.createElement('span');
  taskTitle.classList.add('task-title');
  taskTitle.textContent = `${livro.titulo} - ${livro.autor} - ${livro.genero}`;
  
  const doneIcon = document.createElement('ion-icon');
  doneIcon.setAttribute('class', 'done-btn');
  doneIcon.setAttribute('name', 'checkmark-outline');

  const removeIcon = document.createElement('ion-icon');
  removeIcon.setAttribute('class', 'remove-btn');
  removeIcon.setAttribute('name', 'close-outline');

  // Adicione os elementos ao item da lista
  taskListItem.appendChild(taskTitle);
  taskListItem.appendChild(doneIcon);
  taskListItem.appendChild(removeIcon);

  // Adicione o item da lista à lista
  taskList.appendChild(taskListItem);

  // Limpar os campos de entrada
  document.querySelector('#ititulo-livro').value = '';
  document.querySelector('#iautor').value = '';
  document.querySelector('#igenero').value = '';
});
