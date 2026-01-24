const createHomePageTemplate = () => /*html*/ `
    <html>
    <head>
        <title>My Reading List</title>
        <script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.8/dist/htmx.min.js" integrity="sha384-/TgkGk7p307TH7EXJDuUlgG3Ce1UVolAOFopFekQkkXihi5u/6OCvVKyz1W+idaz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/styles.css">
    </head>
    <body>
        <header>
            <h1>My Reading List</h1>
        </header>
        <main>
            <div class="search" style="text-align: center;">
                <input
                    type="search"
                    name="search"
                    placeholder="Search books by title..."
                    hx-post="/books/search"
                    hx-trigger="keyup changed delay:300ms"
                    hx-target=".book-list"
                />
            </div>
            <div class="book-list">
                <button hx-get="/books" hx-target=".book-list" hx-trigger="dblclick">Show Books</button>
            </div>

            <div class="add-book-form">
                <h2>What do you want to read?</h2>
                <form
                    hx-post="/books"
                    hx-target=".book-list ul"
                    hx-swap="beforeend"
                    hx-on::after-request="document.querySelector('form').reset()"
                >
                    <input type="text" name="title" placeholder="Title" required />
                    <input type="text" name="author" placeholder="Author" required />
                    <button>Add Book</button>
                </form>
            </div>
        </main>
    </body>
    </html>
`;

export default createHomePageTemplate;
