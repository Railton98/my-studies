import request from 'supertest';
import app from './app.js';
import createListTemplate from './views/list.js';
import BOOKS_DATA from './data/data.js';

describe('Books API', () => {
  describe('POST /books/search', () => {
    it('returns filtered list of books matching search text', async () => {
      const response = await request(app)
        .post('/books/search')
        .type('form')
        .send({ search: 'Final' })
        .expect(200);

      // Check that the response contains the matching book
      expect(response.text).toContain('The Final Empire');
      expect(response.text).toContain('Brandon Sanderson');
      // Check that non-matching books are not included
      expect(response.text).not.toContain('The Way of Kings');
    });

    it('returns empty list when no books match search text', async () => {
      const response = await request(app)
        .post('/books/search')
        .type('form')
        .send({ search: 'nonexistent' })
        .expect(200);

      expect(response.text).toContain('<ul>');
      expect(response.text).not.toContain('The Final Empire');
      expect(response.text).not.toContain('The Way of Kings');
    });

    it('is case-insensitive when searching', async () => {
      const response = await request(app)
        .post('/books/search')
        .type('form')
        .send({ search: 'FINAL' })
        .expect(200);

      expect(response.text).toContain('The Final Empire');
    });
  });

  describe('GET /books', () => {
    it('returns the full list of books', async () => {
      const response = await request(app)
        .get('/books')
        .expect(200);

      // Check that all books are included
      expect(response.text).toContain('The Final Empire');
      expect(response.text).toContain('The Way of Kings');
      expect(response.text).toContain('Brandon Sanderson');
      
      // Check that the list structure is present
      expect(response.text).toContain('<ul>');
      expect(response.text).toContain('</ul>');
    });
  });
});

describe('createListTemplate', () => {
  it('correctly renders HTML for given books array', () => {
    const testBooks = [
      { id: '1', title: 'Test Book 1', author: 'Test Author 1' },
      { id: '2', title: 'Test Book 2', author: 'Test Author 2' },
    ];

    const html = createListTemplate(testBooks);

    // Check that the HTML contains a ul element
    expect(html).toContain('<ul>');
    expect(html).toContain('</ul>');

    // Check that all books are rendered
    expect(html).toContain('Test Book 1');
    expect(html).toContain('Test Author 1');
    expect(html).toContain('Test Book 2');
    expect(html).toContain('Test Author 2');

    // Check that li elements are present for each book
    expect(html).toContain('data-id="1"');
    expect(html).toContain('data-id="2"');
  });

  it('renders empty ul for empty books array', () => {
    const html = createListTemplate([]);

    expect(html).toContain('<ul>');
    expect(html).toContain('</ul>');
    expect(html).not.toContain('<li');
  });

  it('renders single book correctly', () => {
    const testBooks = [
      { id: '42', title: 'Single Book', author: 'Single Author' },
    ];

    const html = createListTemplate(testBooks);

    expect(html).toContain('Single Book');
    expect(html).toContain('Single Author');
    expect(html).toContain('data-id="42"');
  });
});
