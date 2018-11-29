CREATE TABLE users (
  username VARCHAR PRIMARY KEY,
  password VARCHAR,
  name VARCHAR
);

CREATE TABLE if not exists news (
    id INTEGER PRIMARY KEY,
    title VARCHAR,
    published INTEGER, -- date when the article was published in epoch format
    tags VARCHAR, -- comma separated tags
    username VARCHAR REFERENCES users, -- who wrote the article
    introduction VARCHAR,
    fulltext VARCHAR,
    upvotes integer,
    downvotes integer,----default ou depois inicializa
    count integer default 0, --wtf 
    LastSeen TEXT default (datetime('now'))
);

CREATE TABLE comments (
  id INTEGER PRIMARY KEY,
  news_id INTEGER REFERENCES news,
  username VARCHAR REFERENCES users,
  published INTEGER, -- date when news item was published in epoch format
  text VARCHAR,
upvotes integer default 0,
downvotes integer default 0
);

create Table reply
(
    id  integer primary key,
    idc integer references comments,
    username varchar references users,
    published integer,
    text varchar,
    upvotes integer default 0,
    downvotes integer default 0
);


-- All passwords are 1234 in SHA-1 format
INSERT INTO users VALUES ("dominic", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Dominic Woods");
INSERT INTO users VALUES ("zachary", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Zachary Young");
INSERT INTO users VALUES ("alicia", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Alicia Hamilton");
INSERT INTO users VALUES ("abril", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Abril Cooley");


INSERT INTO news VALUES (0,
  'Lorem ipsum dolor sit amet, consectetur',
  1507901651,
  'politics,economy',
  'abril',
  'Nulla sem non feugiat pharetra.',
  'sod jiejr',1,2,0,datetime('now'));
  
INSERT INTO news VALUES (NULL,
  'Donec placerat tempor ex sit amet',
  1508074451,
  'local,life',
  'alicia',
  'Nam aliqtus leo a justo.',
  'Morbi aretraempor. Nam vestibulum in erat et sagittis. Donec venenatis, ante vitae tristique tristique, nisi metus aliquet.');

INSERT INTO comments VALUES (NULL,
  4,
  'dominic',
  1508247532,
  'Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.'
);

INSERT INTO comments VALUES (NULL,
  4,
  'abril',
  1508247632,
  'Duis scelerisque purus fermentum turpis euismod congue. Phasellus sit amet sem mollis, imperdiet quam porta, volutpat purus. In et sodales urna, sed cursus lectus. Vivamus a massa vitae nisl lobortis laoreet nec tristique magna. Mauris egestas ipsum eu sem lacinia.'
);

INSERT INTO comments VALUES (NULL,
  3,
  'alicia',
  1508247132,
  'Phasellus at neque nec nunc scelerisque eleifend eu eu risus. Praesent in nibh viverra, posuere ligula condimentum, accumsan tellus. Vivamus varius sem a mauris finibus, ac iaculis risus scelerisque. Nullam fermentum leo dui, at fermentum tellus consequat id. Pellentesque eleifend.'
);

