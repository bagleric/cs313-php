CREATE TABLE teacher(
    id              SERIAL          NOT NULL    PRIMARY KEY
    , email         VARCHAR(200)    NOT NULL
    , first_name    VARCHAR(200)    NOT NULL
    , last_name     VARCHAR(200)    NOT NULL
    , user_password VARCHAR(100)    NOT NULL  
);


CREATE TABLE levels (
    id              SERIAL          NOT NULL    PRIMARY KEY
    , level_name    varchar(30)     NOT NULL
);

CREATE TABLE student(
    id              SERIAL          NOT NULL    PRIMARY KEY
    , first_name    VARCHAR(200)    NOT NULL
    , last_name     VARCHAR(200)    NOT NULL
    , music_level   INT             NOT NULL
    , user_password VARCHAR(100)    NOT NULL  
    , FOREIGN KEY (music_level) REFERENCES levels(id)
);

    
CREATE TABLE practice_records(
    id              SERIAL          NOT NULL    PRIMARY KEY
    , student       INT             NOT NULL
    , practice_date DATE            NOT NULL
    , practice_time INT             NOT NULL    
    , comments      TEXT   
    , FOREIGN KEY (student) REFERENCES levels(id)

);

CREATE TABLE studio_events (
    id              SERIAL          NOT NULL    PRIMARY KEY
    , name          VARCHAR(200)    NOT NULL    
    , event_date    DATE            NOT NULL
    , description   TEXT            NOT NULL
);


INSERT INTO levels (level_name) VALUES ('One');
INSERT INTO levels (level_name) VALUES ('Two');
INSERT INTO levels (level_name) VALUES ('Three');
INSERT INTO levels (level_name) VALUES ('Four');
INSERT INTO levels (level_name) VALUES ('Five');
INSERT INTO levels (level_name) VALUES ('Six');
INSERT INTO levels (level_name) VALUES ('Seven');
INSERT INTO levels (level_name) VALUES ('Eight');
INSERT INTO levels (level_name) VALUES ('Nine');
INSERT INTO levels (level_name) VALUES ('Ten');
INSERT INTO levels (level_name) VALUES ('Teacher');


INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Amy', 'Anderson',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Bruce', 'Butler',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Cameron', 'Colter',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Dayna', 'Doit',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Eric', 'Erickson',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Frida', 'Flores',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('George', 'Grants',1, 'password');
INSERT INTO student (first_name, last_name, music_level, user_password) VALUES ('Haley', 'Hallwood',1, 'password');
INSERT INTO teacher (email, first_name, last_name, user_password) VALUES ('email@test.com','Amira', 'Bagley', 'teacher');

INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (1, '2015-12-17',30, 'I love Practicing');
INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (1, '2015-12-17',30, 'I love Practicing AGAIN');
INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (2, '2015-12-17',30, 'I love Practicing');
INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (3, '2015-12-17',30, 'I love Practicing');
INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (4, '2015-12-17',30, 'I love Practicing');
INSERT INTO practice_records (student, practice_date,practice_time, comments) VALUES (5, '2015-12-17',30, 'I love Practicing');
