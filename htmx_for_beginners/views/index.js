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
            <div class="book-list">
                <!-- book list here later -->
            </div>

            <div class="add-book-form">
                <h2>What do you want to read?</h2>
                <!-- form template here later -->
            </div>
        </main>
    </body>
    </html>
`;

export default createHomePageTemplate;
