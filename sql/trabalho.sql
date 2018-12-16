Drop table if exists users
Drop table if exists userlikenews
Drop table if exists news
Drop table if exists userlikecomments
Drop table if exists comments
Drop table if exists reply


CREATE TABLE users (
  username VARCHAR PRIMARY KEY,
  password VARCHAR,
  name VARCHAR,
  email VARCHAR,
  profImgUrl VARCHAR
);


INSERT INTO users VALUES ("dominic", "$2y$12$8WypB2UCcB6rsSiwXu3KkOxW3r9KInvKIX1/z8U2RWMBrPltjug2K", "Dominic Woods", 'dominic@gmail.com','https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/President_Vladimir_Putin.jpg/220px-President_Vladimir_Putin.jpg'); --dominic123
INSERT INTO users VALUES ('abril','$2y$12$KUUoacqjA6UzY4K1os1Qy.BFtoBg4TSBGp6goI7BuaHqWli4lsRZ2','Abril Cooley','ACooley@gmail.com','https://ssli.ulximg.com/image/740x493/gallery/1516391814_86a3f68511bf3f10321b56a10b997365.jpg/73b0e90570cc1ca5d38c500d7fd2b983/1516391814_a5e260896c61125fdae94033d2c2e636.jpg'); --abril123
INSERT INTO users VALUES ("nofilmynofucky", "$2y$12$UcsUKYAqBb.4xyyQA8fHCeCjtDESj3aCgmLtC8nMalTVq2BzBwfDq", "Ze Manel", "manelZe@gmail.com",'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Sir_Andrew_Noble_c1907.jpg/220px-Sir_Andrew_Noble_c1907.jpg'); --nofilmynofucky

-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikenews (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    news_id INTEGER REFERENCES news,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikenews VALUES (NULL, "dominic", 1, 1, 0);

-----------------------------------------------------------------------------------------------------

CREATE TABLE news (
    id INTEGER PRIMARY KEY,
    title VARCHAR,
    published INTEGER, -- date when the article was published in epoch format USAR ISTO EM PHP  (datetime('now'))
    tags VARCHAR, -- comma separated tags
    username VARCHAR REFERENCES users, -- who wrote the article
    imageUrl VARCHAR,
    fulltext VARCHAR,
    upvotes integer,
    downvotes integer,----default ou depois inicializa
    count integer default 0 -- aqui e para o contador de comentarios
);


INSERT INTO news VALUES (NULL,
    'Lorem ipsum dolor sit amet, consectetur',
    1507901651,
    'politics,economy',
    'abril',
    "https://i.redd.it/0j5y38xz2f121.jpg",
    'Nulla sem non feugiat pharetra.',
    1,2,2);
  
INSERT INTO news VALUES (NULL,
    'sei la',
    1507901652,
    'politics,HMMMM',
    'dominic',
    "https://dummyimage.com/600x300/008ebd/fff.jpg&text=business",
    'Nulla sem non feugiat pharetra.',
    1000,6,0);

INSERT INTO news VALUES (NULL,
  'Macaque is huge',
  1543619157,
  'WTF,HMMMM',
  'nofilmynofucky',
  "https://images.unsplash.com/photo-1516956431828-b10b67f654d0?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=1abfd58b74a89775f1c75a22cc8b1605&w=1000&q=80",
  'sod jiejr',
  16932,1014,0);


-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikecomments (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    comment_id INTEGER REFERENCES comments,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikecomments VALUES (NULL, "dominic", 1, 1, 0);

-----------------------------------------------------------------------------------------------------

CREATE TABLE comments (
    id INTEGER PRIMARY KEY,
    news_id INTEGER REFERENCES news,
    username VARCHAR REFERENCES users,
    published INTEGER, -- date when news item was published in epoch format
    text VARCHAR,
    upvotes integer default 0,
    downvotes integer default 0
);

INSERT INTO comments VALUES (NULL,
  1,
  'dominic',
  1508247532,
  'Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.',
  1,0
);


-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikereply (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    reply_id INTEGER REFERENCES comments,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikereply VALUES (NULL, "dominic", 1, 1, 0);

-----------------------------------------------------------------------------------------------------

CREATE TABLE reply
(
    id  integer primary key,
    idc integer references comments,
    username varchar references users,
    published integer,
    text varchar,
    upvotes integer default 0,
    downvotes integer default 0
);

INSERT INTO reply VALUES (NULL,
  1,
  'abril',
  1508244444,
  'Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.',
  2,1
);