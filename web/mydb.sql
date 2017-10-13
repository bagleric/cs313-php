CREATE TABLE students(
    id              SERIAL          NOT NULL    PRIMARY KEY
    , first_name    VARCHAR(255)    NOT NULL
    , last_name     VARCHAR(255)    NOT NULL
    , student_level FOREIGN KEY REFERENCES levels(id)
);

CREATE TABLE levels (
    id              SERIAL          NOT NULL    PRIMARY KEY
    , level_name    varchar(30)     NOT NULL
);
    
CREATE TABLE practice_records(
    id              SERIAL          NOT NULL    PRIMARY KEY
    , student       FOREIGN KEY REFERENCES students(id) NOT NULL
    , practice_date DATE            NOT NULL
    , practice_time INT             NOT NULL    
    , comments      TEXT            
);