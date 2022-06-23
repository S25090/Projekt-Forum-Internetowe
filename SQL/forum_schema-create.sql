CREATE TABLE uzytkownicy (
user_id     INT(8) NOT NULL AUTO_INCREMENT,
user_name   VARCHAR(30) NOT NULL,
user_pass   VARCHAR(255) NOT NULL,
user_email  VARCHAR(255) NOT NULL,
user_date   DATETIME NOT NULL,
user_level  INT(8) NOT NULL,
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
);

CREATE TABLE kategorie (
cat_id          INT(8) NOT NULL AUTO_INCREMENT,
cat_name        VARCHAR(255) NOT NULL,
cat_description     VARCHAR(255) NOT NULL,
UNIQUE INDEX cat_name_unique (cat_name),
PRIMARY KEY (cat_id)
);

CREATE TABLE pytania (
pytanie_id        INT(8) NOT NULL AUTO_INCREMENT,
pytanie_subject       VARCHAR(255) NOT NULL,
pytanie_date      DATETIME NOT NULL,
pytanie_cat       INT(8) NOT NULL,
pytanie_by        INT(8) NOT NULL,
PRIMARY KEY (pytanie_id)
);

CREATE TABLE komentarze (
komentarz_id         INT(8) NOT NULL AUTO_INCREMENT,
komentarz_content       TEXT NOT NULL,
komentarz_date       DATETIME NOT NULL,
komentarz_topic      INT(8) NOT NULL,
komentarz_by     INT(8) NOT NULL,
PRIMARY KEY (komentarz_id)
);

ALTER TABLE pytania ADD FOREIGN KEY(pytanie_cat) REFERENCES kategorie(cat_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pytania ADD FOREIGN KEY(pytanie_by) REFERENCES uzytkownicy(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE komentarze ADD FOREIGN KEY(komentarz_topic) REFERENCES pytania(pytanie_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE komentarze ADD FOREIGN KEY(komentarz_by) REFERENCES uzytkownicy(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;

-- uzytkownik ala.a z poziomem admina haslo: admin
INSERT INTO uzytkownicy(user_name, user_pass, user_email ,user_date, user_level)
VALUES('ala.a','d033e22ae348aeb5660fc2140aec35850c4da997','alicja.wosik@gmail.com','2022-06-23 20:53:45',2);

-- uzytkownik ala.m z poziomem moderatora haslo: admin
INSERT INTO uzytkownicy(user_name, user_pass, user_email ,user_date, user_level)
VALUES('ala.m','d033e22ae348aeb5660fc2140aec35850c4da997','alicja.wosik@gmail.com','2022-06-23 20:53:45',2);