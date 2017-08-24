# Markdown Blog
is a PHP blog application that uses markdown syntax to format and organize text.
It's recommended to paste markdown content from a more competent IDE into the textarea.

### Features
* Unauthenticated User can view all blogs
* Authenticated User can create blogs
* User can view blogs formatted through Markdown syntax
* User can register and create accounts
* Application is protected from SQL injections
* Application is protected from XSS

### Dependencies
* Backend
1. PHP
2. MySQL
3. Shared Hosting
4. SSL

* Frontend
1. jQuery
2. Bootstrap
3. FontAwesome
4. Marked

### Model
```
USER
----> id (primary key)
----> name (varchar)
----> email (varchar)
----> password (8 required)
----> date_created (timestamp)

BLOG
----> id (primary key)
----> user_id (foreign key)
----> topic (varchar)

ARTICLE
----> id (primary key)
----> blog_id (foreign key)
----> user_id (foreign key)
----> date_modified (timestamp)
----> title (varchar)
----> content (text)
----> share (boolean)

```

### Author
Neptune Michael Cabelin

### License
MIT
