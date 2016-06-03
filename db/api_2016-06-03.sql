PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE 'BodyPatt' (
    'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
    'Name' TEXT NOT NULL, 
    'Priority' INTEGER NOT NULL DEFAULT 9999,
    'Pattern' TEXT NOT NULL
);
INSERT INTO "BodyPatt" VALUES(1,'Request',1,'/.*?их вопрос[:\s]+

\s*(?''Text''.+?)

.*?Вопрос относится к вашей заявке.*?
Номер заявки[:\s]+(?''Number''\d+).*?созданной[:\s]+(?''Date''[\d\/]+ [\d\:]+)
Описание[:\s]+(?''Desc''[^\n]*)
Доп.*?инф.*?[:\s]+(?''Append''[^\n]*)
Конт.*?тел.*?[:\s]+(?''Contact''[^\n]*)
Название ТСП[:\s]+(?''Name''[^\n]*)/uis');
INSERT INTO "BodyPatt" VALUES(2,2,'Request','/Город[:\s]+(?''Addr''[^\n]*)/uis');

CREATE TABLE 'MailPatt' (
    'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
    'Priority' INTEGER NOT NULL DEFAULT 9999,
    'Pattern' TEXT NOT NULL,
    'BodyPattern' TEXT NOT NULL, 
    'Model' TEXT NOT NULL
);
INSERT INTO "MailPatt" VALUES(1,1,'Subject|/Вопрос по вашей заявке номер/ui|','Request','Request');
INSERT INTO "MailPatt" VALUES(2,9999,'/.*/ui','IGNORE','IGNORE');

DELETE FROM sqlite_sequence;

CREATE INDEX 'IDX_NAME' ON "BodyPatt" ("Name" ASC, "Priority" ASC);
CREATE INDEX 'IDX_PRIORITY' ON "MailPatt" ("Priority" ASC);

COMMIT;
