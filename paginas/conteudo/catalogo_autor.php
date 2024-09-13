<?php include '../../includes/header.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/catalogo_autor.css">
    <title>Lista de Autores</title>
</head>
<body>
    <main>
        <div class="content-wrapper">
            <h1>Lista de Autores</h1>
            <div class="container">
                <div class="button-container">
                    <button class="sort-button" onclick="sortList('asc')">Ordenar A-Z</button>
                    <button class="sort-button" onclick="sortList('desc')">Ordenar Z-A</button>
                </div>
                <ul id="authorList">
                    <li class="it_list" data-author="jk_rowling">J.K. Rowling</li>
                    <li class="it_list" data-author="george_rr_martin">George R.R. Martin</li>
                    <li class="it_list" data-author="jr_tolkien">J.R.R. Tolkien</li>
                    <li class="it_list" data-author="isaac_asimov">Isaac Asimov</li>
                    <li class="it_list" data-author="agatha_christie">Agatha Christie</li>
                </ul>
                <div id="bookListContainer">
                    <!-- Book lists will be inserted here -->
                </div>
            </div>
        </div>
        <script>
            const books = {
                'jk_rowling': ['Harry Potter and the Philosopher\'s Stone', 'Harry Potter and the Chamber of Secrets', 'Harry Potter and the Prisoner of Azkaban'],
                'george_rr_martin': ['A Game of Thrones', 'A Clash of Kings', 'A Storm of Swords'],
                'jr_tolkien': ['The Hobbit', 'The Lord of the Rings', 'The Silmarillion'],
                'isaac_asimov': ['Foundation', 'I, Robot', 'The Gods Themselves'],
                'agatha_christie': ['Murder on the Orient Express', 'And Then There Were None', 'The Murder of Roger Ackroyd']
            };
            document.querySelectorAll('.it_list').forEach(item => {
                item.addEventListener('click', function() {
                    const authorKey = this.getAttribute('data-author');
                    const bookListContainer = document.getElementById('bookListContainer');
        
                    // Clear the existing content
                    bookListContainer.innerHTML = '';
                    if (books[authorKey]) {
                        const bookList = document.createElement('div');
                        bookList.classList.add('book-list');
                        const ul = document.createElement('ul');
                        books[authorKey].forEach(book => {
                            const li = document.createElement('li');
                            li.textContent = book;
                            ul.appendChild(li);
                        });
                        bookList.appendChild(ul);
                        bookListContainer.appendChild(bookList);
                        // Toggle the display of the book list
                        if (bookList.style.display === 'none') {
                            bookList.style.display = 'block';
                        } else {
                            bookList.style.display = 'none';
                        }
                    }
                });
            });
            function sortList(order) {
                const ul = document.getElementById('authorList');
                const items = Array.from(ul.getElementsByTagName('li'));
        
                items.sort((a, b) => {
                    const textA = a.textContent.toUpperCase();
                    const textB = b.textContent.toUpperCase();
                    if (order === 'asc') {
                        return textA.localeCompare(textB);
                    } else {
                        return textB.localeCompare(textA);
                    }
                });
                // Clear the current list and re-append the sorted items
                ul.innerHTML = '';
                items.forEach(item => ul.appendChild(item));
            }
        </script>
    </main>
</body>
</html>


