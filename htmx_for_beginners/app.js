import express from "express";
import BOOKS_DATA from "./data/data.js";
import createBookTemplate from "./views/book.js";
import createEditFormTemplate from "./views/edit.js";
import createHomePageTemplate from "./views/index.js";
import createListTemplate from "./views/list.js";

// create app
const app = express();
app.use(express.urlencoded({ extended: false }));

// static assets
app.use(express.static("public"));

// routes
app.get("/", (req, res) => {
  res.send(createHomePageTemplate());
});

app.get("/books", (req, res) => {
  res.send(createListTemplate(BOOKS_DATA));
});

app.post("/books", (req, res) => {
  const { title, author } = req.body;
  const id = Math.random().toString();

  BOOKS_DATA.push({ id, title, author });

  res.redirect(`/books/${id}`);
});

app.get("/books/:id", (req, res) => {
  const { id } = req.params;
  const book = BOOKS_DATA.find((b) => b.id === id);

  res.send(createBookTemplate(book));
});

app.get("/books/edit/:id", (req, res) => {
  const { id } = req.params;
  const book = BOOKS_DATA.find((b) => b.id === id);

  res.send(createEditFormTemplate(book));
});

app.put("/books/:id", (req, res) => {
  const { title, author } = req.body;
  const { id } = req.params;
  const updatedBook = { id, title, author };

  const idx = BOOKS_DATA.findIndex((b) => b.id === id);

  BOOKS_DATA[idx] = updatedBook;

  res.send(createBookTemplate(updatedBook));
});

app.delete("/books/:id", (req, res) => {
  const { id } = req.params;
  const index = BOOKS_DATA.findIndex((b) => b.id === id);

  BOOKS_DATA.splice(index, 1);

  res.send();
});

app.post("/books/search", (req, res) => {
  const text = req.body.search.toLowerCase();

  const filteredBooks = BOOKS_DATA.filter((book) =>
    book.title.toLowerCase().includes(text),
  );

  res.send(createListTemplate(filteredBooks));
});

// listen to port
app.listen(3000, () => {
  console.log("App listening on port 3000");
});
