CREATE TABLE topic(
    id          SERIAL          NOT NULL    PRIMARY KEY
    , name      VARCHAR(100)    NOT NULL
    
);

INSERT INTO topic(name) VALUES('Faith');
INSERT INTO topic(name) VALUES('Sacrifice');
INSERT INTO topic(name) VALUES('Charity');


CREATE TABLE topic_link (
    id          SERIAL      NOT NULL
    , scripture INTEGER     NOT NULL
    , topic     INTEGER     NOT NULL
    , FOREIGN KEY (scripture) REFERENCES scriptures(id)
    , FOREIGN KEY (topic) REFERENCES topic(id)
);


GRANT SELECT, INSERT, UPDATE ON ALL TABLES IN SCHEMA public TO teacher;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO teacher;

ALTER ROLE teacher WITH PASSWORD 'teacher';