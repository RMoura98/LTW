


CREATE TABLE users (
  username VARCHAR PRIMARY KEY,
  password VARCHAR,
  name VARCHAR,
  email VARCHAR,
  profImgUrl VARCHAR
);


INSERT INTO users VALUES ("dominic", "$2y$12$8WypB2UCcB6rsSiwXu3KkOxW3r9KInvKIX1/z8U2RWMBrPltjug2K", "Dominic Woods", 'dominic@gmail.com','https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/President_Vladimir_Putin.jpg/220px-President_Vladimir_Putin.jpg'); --dominic123
INSERT INTO users VALUES ('abril','$2y$12$.DyZf/gHOEpQn6uDxRIsLeFRyzonhy6lJdsiUZ1KOq1vynkVPpe12','Abril Cooley','ACooley@gmail.com','https://ssli.ulximg.com/image/740x493/gallery/1516391814_86a3f68511bf3f10321b56a10b997365.jpg/73b0e90570cc1ca5d38c500d7fd2b983/1516391814_a5e260896c61125fdae94033d2c2e636.jpg'); --123123
INSERT INTO users VALUES ("nofilmynofucky", "$2y$12$UcsUKYAqBb.4xyyQA8fHCeCjtDESj3aCgmLtC8nMalTVq2BzBwfDq", "Ze Manel", "manelZe@gmail.com",'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Sir_Andrew_Noble_c1907.jpg/220px-Sir_Andrew_Noble_c1907.jpg'); --nofilmynofucky
INSERT INTO users VALUES ("RMoura98", "$2y$12$.DyZf/gHOEpQn6uDxRIsLeFRyzonhy6lJdsiUZ1KOq1vynkVPpe12", "Ricardo Moura", "rmoura@gmail.com",'https://i.imgur.com/p8ocvty.png'); --123123

-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikenews (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    news_id INTEGER REFERENCES news,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikenews VALUES (NULL, "dominic", 1, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "dominic", 2, 0, 1);
INSERT INTO userlikenews VALUES (NULL, "dominic", 3, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "abril", 2, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "abril", 5, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "abril", 6, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "nofilmynofucky", 2, 0, 1);
INSERT INTO userlikenews VALUES (NULL, "nofilmynofucky", 5, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "nofilmynofucky", 6, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "RMoura98", 3, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "RMoura98", 4, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "RMoura98", 5, 1, 0);
INSERT INTO userlikenews VALUES (NULL, "RMoura98", 6, 1, 0);

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

--1
INSERT INTO news VALUES (NULL,
    'It almost seems intentional',
    1542326400,
    'CrappyDesign,wtf',
    'abril',
    "https://i.imgur.com/7hRh7Rs.jpg",
    '',
    1,2,0);

--2
INSERT INTO news VALUES (NULL,
    'My sister made a sweater for Spaghetti...I think he loves it.',
    1507901651,
    'aww,hmmm',
    'abril',
    "https://i.redd.it/yj0ny67qe5601.jpg",
    '',
    1,2,2);

--3
INSERT INTO news VALUES (NULL,
    'Good boy got the photo 10/10',
    1517901652,
    'aww,dogs',
    'dominic',
    "https://i.redd.it/g9w2q9iq3ok11.jpg",--https://i.imgur.com/tBNEY5P.jpg
    '',
    1000,6,0);

--4
INSERT INTO news VALUES (NULL,
  'Laser-cut paper notecards: As you use them, a hidden object is excavated',
  1543619157,
  'oddlysatisfying',
  'nofilmynofucky',
  "https://i.redd.it/tvfwsibg5ha01.gif",
  'A bit more info about this Japanese Omoshiro Block: https://www.thisiscolossal.com/2018/01/omoshiro-block-a-paper-memo-pad-that-excavates-objects-as-it-gets-used/',
  16932,1014,0);

--5
INSERT INTO news VALUES (NULL,
  'Best 404 page',
  1545210000,
  'ProgrammerHumor',
  'RMoura98',
  "https://i.imgur.com/iINfZri.png",
  '',
  405,1,0);

--6
INSERT INTO news VALUES (NULL,
  'Is this the right place to post this?',
  1544973900,
  'ProgrammerHumor',
  'RMoura98',
  "https://i.redd.it/qsbkmaqnplm11.jpg",
  '',
  501,1,0);

--7
INSERT INTO news VALUES (NULL,
  'my little Ollie... ❤️',
  1543973900,
  'aww,dogs',
  'nofilmynofucky',
  "https://i.redd.it/pzkqvsv95m421.jpg",--https://i.imgur.com/nZHhGwh.jpg
  'I don’t really have anyone to share this with right now so I’m deciding to share it here with you guys ... my little Ollie ... graduated from training class today and I couldn’t be more proud of this very good boy.',
  100,1,2);

--8
INSERT INTO news VALUES (NULL,
  'Going for a celebration knee slide at the end of a race.',
  1543943900,
  'Wellthatsucks',
  'nofilmynofucky',
  "https://i.imgur.com/Y9Spc2R.gif",
  '',
  57,1,0);

--9
INSERT INTO news VALUES (NULL,
  'hmmm',
  1543943900,
  'hmmm',
  'dominic',
  "https://i.redd.it/tkaj4j3cgl421.jpg",
  '',
  23,12,0);

--10
INSERT INTO news VALUES (NULL,
  '🔥 Fearless lion intimidates a crocodile who got too close to his pride 🐊',
  1541943900,
  'NatureIsFLit',
  'abril',
  "https://i.imgur.com/3OglgS6.gif",
  '',
  12,1,0);

--11
INSERT INTO news VALUES (NULL,
  'Owls are cute! Owls are.... cute? 🦉🦉🦉',
  1541945900,
  'wtf,hmmm',
  'dominic',
  "http://static.boredpanda.com/blog/wp-content/uploads/2017/01/owls-without-feathers-fb__700-png.jpg",
  'I just googled owls without feathers I regret everything',
  5,24,0);

--12
INSERT INTO news VALUES (NULL,
  'A shot I took on my last mission. Thought it turned out pretty good.',
  1541943900,
  'pics',
  'RMoura98',
  "https://i.redd.it/peevheqxti421.jpg",
  '',
  50,14,3);

--13
INSERT INTO news VALUES (NULL,
  'They asked him what gaming chair he was using.',
  1541543900,
  'gaming,funny',
  'nofilmynofucky',
  "https://media.giphy.com/media/nqpLr1r5d6r18FqjAj/giphy.gif",
  '',
  50,14,0);

--14
INSERT INTO news VALUES (NULL,
  'These damn ads are what did it!',
  1541243900,
  'funny',
  'nofilmynofucky',
  "https://i.imgur.com/GDZXhMR.gif",
  '',
  150,75,0);

--15
INSERT INTO news VALUES (NULL,
  'Waiting for food',
  1541943900,
  'cats',
  'nofilmynofucky',
  "https://i.redd.it/47dnvj48n5421.jpg", --https://i.imgur.com/Wb0qV9z.jpg
  '',
  123,25,0);

--16
INSERT INTO news VALUES (NULL,
  'Bob Ross painting rocks like its nothing',
  1544280081,
  'oddlysatisfying',
  'RMoura98',
  "https://i.imgur.com/AAV1K4T.gif",
  '',
  233,25,0);

--17
INSERT INTO news VALUES (NULL,
  'Do you think we need a DNA test?',
  1544973948,
  'aww,cats',
  'RMoura98',
  "https://i.imgur.com/ADaAy6V.jpg", -- https://i.imgur.com/93vVdLP.jpg
  '',
  533,25,0);

--18
INSERT INTO news VALUES (NULL,
  'Finnish ski jumping team',
  1543973948,
  'funny',
  'RMoura98',
  "https://i.imgur.com/0zbQEWC.gif",
  '',
  333,25,2);

--19
INSERT INTO news VALUES (NULL,
  'A bird flew in my window, sh*t on my laptop, and decided to die right in front of me. How is your day going?',
  1544978640,
  'funny,pics',
  'abril',
  "https://i.imgur.com/etUpE0M.jpg",
  '',
  123,2,0);

--20
INSERT INTO news VALUES (NULL,
  'A homeless man in Brazil was rushed to hospital. These 4 street dogs he has been looking after are waiting at the entrance of the hospital for him.',
  1544278640,
  'aww,pics',
  'abril',
  "https://i.imgur.com/yydBFtE.jpg",
  '',
  123,2,0);

--21
INSERT INTO news VALUES (NULL,
  'Trump boards Air Force One with toilet paper stuck to his shoe',
  1544278240,
  'funny',
  'RMoura98',
  "https://i.imgur.com/JpDig9C.gif",
  '',
  23,2,0);


-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikecomments (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    comment_id INTEGER REFERENCES comments,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikecomments VALUES (NULL, "abril", 1, 1, 0);
INSERT INTO userlikecomments VALUES (NULL, "nofilmynofucky", 2, 1, 0);

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
  2,
  'RMoura98',
  1508247532,
  'I gotta ask, how did you get him in there?',
  1,0
);

INSERT INTO comments VALUES (NULL,
  7,
  'dominic',
  1543974000,
  'Thats a great photo. Frame it.',
  1,0
);
INSERT INTO comments VALUES (NULL,
  12,
  'dominic',
  1541944900,
  'Latest mission or last mission?',
  1,0
);
INSERT INTO comments VALUES (NULL,
  12,
  'abril',
  1541945900,
  'Absolute unit.',
  1,0
);
INSERT INTO comments VALUES (NULL,
  18,
  'dominic',
  1543973998,
  'Error 404: F*ck not found.',
  19,0
);
INSERT INTO comments VALUES (NULL,
  18,
  'dominic',
  1543973998,
  'Exactly how my expression looks when I text lol',
  23,0
);


-----------------------------------------------------------------------------------------------------

CREATE TABLE userlikereply (
    id INTEGER PRIMARY KEY,
    username VARCHAR REFERENCES users,
    reply_id INTEGER REFERENCES comments,
    upvote integer default 0,
    downvote integer default 0
);

INSERT INTO userlikereply VALUES (NULL, "RMoura98", 1, 1, 0);
INSERT INTO userlikereply VALUES (NULL, "dominic", 2, 1, 0);

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
  'I just kinda put his head in one end and he just wiggles to the other end on his own. I just hold the sweater in place while he works his way down. He stops just before his head pops out the other end and just chills in it.',
  2,1
);

INSERT INTO reply VALUES (NULL,
  2,
  'nofilmynofucky',
  1543974500,
  'Absolutely!!!!',
  7,1
);
INSERT INTO reply VALUES (NULL,
  3,
  'RMoura98',
  1541945100,
  'sorry, Latest.',
  7,1
);