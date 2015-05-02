CREATE TABLE Kayttaja(
  nimi varchar(50) PRIMARY KEY,
  salasana varchar(50) NOT NULL
);

CREATE TABLE Postaus(
  id SERIAL PRIMARY KEY,
  kayttaja varchar(50) NOT NULL REFERENCES Kayttaja(nimi),
  pvm Date NOT NULL,
  otsikko varchar(200),
  leipateksti TEXT NOT NULL,
  julkaistu char NOT NULL
);

CREATE TABLE Kategoria(
  nimi TEXT PRIMARY KEY,
  kuvaus TEXT
);

CREATE TABLE PostauksenKategoria(
  postausID integer NOT NULL REFERENCES Postaus(id),
  kategoriannimi TEXT NOT NULL REFERENCES Kategoria(nimi),
  PRIMARY KEY (postausID, kategoriannimi)
);
