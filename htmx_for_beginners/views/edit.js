const createEditFormTemplate = (book) => /*html*/ `
    <form>
        <input type="text" name="title" placeholder="Title" value="${book.title}" required />
        <input type="text" name="author" placeholder="Author" value="${book.author}" required />
        <button>Add Book</button>
    </form>
`;

export default createEditFormTemplate;
