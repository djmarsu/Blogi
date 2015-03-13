CREATE TABLE Kayttaja(
  nimi varchar(50) PRIMARY KEY,
  salasana varchar(50) NOT NULL
);

CREATE TABLE Blogi(
  nimi varchar(50) PRIMARY KEY,
  kenen varchar(50) NOT NULL REFERENCES Kayttaja(nimi),
  osoite varchar(30) NOT NULL
);

CREATE TABLE Postaus(
  id integer PRIMARY KEY,
  blogi varchar(50) NOT NULL REFERENCES Blogi(nimi),
  pvm Date NOT NULL,
  otsikko varchar(200),
  leipateksti TEXT NOT NULL,
  julkaistu char NOT NULL
);

CREATE TABLE Kategoria(
  nimi varchar(50) PRIMARY KEY,
  kuvaus TEXT
);

CREATE TABLE PostauksenKategoria(
  postausID integer NOT NULL REFERENCES Postaus(id),
  kategoriannimi varchar(50) NOT NULL REFERENCES Kategoria(nimi)
);
