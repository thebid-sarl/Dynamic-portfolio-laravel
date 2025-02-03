DROP TABLE IF EXISTS Certificates;

DROP TABLE IF EXISTS Skills;

DROP TABLE IF EXISTS Formations;

DROP TABLE IF EXISTS Experiences;

DROP TABLE IF EXISTS Person;

DROP TABLE IF EXISTS SuperUser;

CREATE TABLE SuperUsers(
    id VARCHAR(100) PRIMARY KEY NOT NULL,
    hashPassword VARCHAR(100) NOT NULL
);

CREATE TABLE Person(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firstname VARCHAR(60),
    lastname VARCHAR(100),
    birthday DATE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone varchar(15) NOT NULL UNIQUE,
    degree VARCHAR(32),
    country VARCHAR(100),
    city VARCHAR(100),
    headerImage VARCHAR(100),
    coverImage VARCHAR(100),
    aboutImage VARCHAR(100),
    domain VARCHAR(100),
    presentation TEXT,
    github VARCHAR(100),
    twitter VARCHAR(100),
    skype VARCHAR(100),
    linkedin VARCHAR(100),
    idSuperUser VARCHAR(100) NOT NULL,
    FOREIGN KEY(idSuperUser) REFERENCES SuperUser(id)
);

CREATE TABLE Experiences(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idPerson INTEGER NOT NULL,
    title VARCHAR(100),
    beginDate DATE,
    endDate DATE,
    companyName VARCHAR(120),
    country VARCHAR(100),
    city VARCHAR(100),
    descriptions TEXT,
    FOREIGN KEY(idPerson) REFERENCES Person(id)
);

CREATE TABLE Formations(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idPerson INTEGER NOT NULL,
    title VARCHAR(100),
    beginDate DATE,
    endDate DATE,
    schoolName VARCHAR(255),
    country VARCHAR(100),
    city VARCHAR(100),
    descriptions TEXT,
    FOREIGN KEY(idPerson) REFERENCES Person(id)
);

CREATE TABLE Skills(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idPerson INTEGER NOT NULL,
    title VARCHAR(100),
    descriptions TEXT,
    FOREIGN KEY(idPerson) REFERENCES Person(id)
);

CREATE TABLE Certificates(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idPerson INTEGER NOT NULL,
    title VARCHAR(100),
    receiptDate DATE,
    organizationName VARCHAR(255),
    country VARCHAR(100),
    city VARCHAR(100),
    descriptions TEXT,
    FOREIGN KEY(idPerson) REFERENCES Person(id)
);