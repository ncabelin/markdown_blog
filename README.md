# Markdown Blog
is a PHP blog application that uses markdown syntax to format and organize text.

### Features
* Unauthenticated User can view all blogs
* Authenticated User can create blogs
* User can view blogs formatted through Markdown syntax
* User can register and create accounts

### Dependencies
* Backend
1. PHP
2. MySQL
3. Laravel

* Frontend
1. jQuery
2. Bootstrap
3. FontAwesome

### Model
```
USER
----> id
----> name
----> email
----> password
----> date_created

BLOG
----> id
----> user_id
----> date
----> content
```

### Author
Neptune Michael Cabelin

### License
MIT
