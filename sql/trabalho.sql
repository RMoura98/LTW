CREATE TABLE users (
  username VARCHAR PRIMARY KEY,
  password VARCHAR,
  name VARCHAR,
  email VARCHAR
);

-- All passwords are  1234in SHA-1 format
INSERT INTO users VALUES ("dominic", "$2y$12$8WypB2UCcB6rsSiwXu3KkOxW3r9KInvKIX1/z8U2RWMBrPltjug2K", "Dominic Woods", 'dominic@gmail.com'); --dominic123
/* INSERT INTO users VALUES ("zachary", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Zachary Young");
INSERT INTO users VALUES ("alicia", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Alicia Hamilton");
INSERT INTO users VALUES ("abril", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Abril Cooley");
INSERT INTO users VALUES ("nofilmynofucky", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Ze Manel"); */

-----------------------------------------------------------------------------------------------------

CREATE TABLE if not exists news (
    id INTEGER PRIMARY KEY,
    title VARCHAR,
    published INTEGER, -- date when the article was published in epoch format USAR ISTO EM PHP  (datetime('now'))
    tags VARCHAR, -- comma separated tags
    username VARCHAR REFERENCES users, -- who wrote the article
    imageUrl VARCHAR,
    introduction VARCHAR,
    fulltext VARCHAR,
    upvotes integer,
    downvotes integer,----default ou depois inicializa
    count integer default 0 --wtf 
);


INSERT INTO news VALUES (NULL,
  'Lorem ipsum dolor sit amet, consectetur',
  1507901651,
  'politics,economy',
  'abril',
  "https://i.redd.it/0j5y38xz2f121.jpg",
  'Nulla sem non feugiat pharetra.',
  'sod jiejr',1,2,0);
  
INSERT INTO news VALUES (NULL,
  'sei la',
  1507901651,
  'politics,HMMMM',
  'dominic',
  "https://dummyimage.com/600x300/008ebd/fff.jpg&text=business",
  'Nulla sem non feugiat pharetra.',
  'sod jiejr',1000,6,1);

INSERT INTO news VALUES (NULL,
  'Macaque is huge',
  1507901651,
  'WTF,HMMMM',
  'nofilmynofucky',
  "https://images.unsplash.com/photo-1516956431828-b10b67f654d0?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=1abfd58b74a89775f1c75a22cc8b1605&w=1000&q=80",
  '',
  'sod jiejr',16932,1014,1000);


--------------------------------------------------------------------------------------------------------------------

CREATE TABLE if not exists  comments (
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


-------------------------------------------------------------------

CREATE TABLE if not exists  reply
(
    id  integer primary key,
    idc integer references comments,
    username varchar references users,
    published integer,
    text varchar,
    upvotes integer default 0,
    downvotes integer default 0
);