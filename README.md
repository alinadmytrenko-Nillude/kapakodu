# Alina Käpakodu

**Autor:** Alina Dmytrenko, IS25
**Kursus:** PHP ja MySQL veebirakenduste loomine

## Kirjeldus

Käpakodu on loomade varjupaiga veebirakendus, mis võimaldab külastajatel tutvuda varjupaigas olevate loomadega ning administraatoril hallata kogu varjupaiga infot.

## Kasutatud tehnoloogiad

- HTML5, CSS3
- [Bootstrap 5](https://getbootstrap.com/) (komponendid ja paigutus)
- [Font Awesome](https://fontawesome.com/) (ikoonid)
- PHP 8.2 (mysqli, Prepared Statements)
- MariaDB 10.11 (MySQL)
- Apache 2.4
- Git ja GitHub


## Projekti struktuur

```
kapakodu/
├── index.php            avaleht (4 viimati lisatud looma andmebaasist)
├── animal.php           looma detailvaade (animal.php?id=...)
├── all_animals.html     kõik loomad (staatiline)
├── contact.html         kontaktileht
├── login.html           sisselogimisleht
├── config.example.php   andmebaasi seadete näidis
├── .gitignore           (config.php ei lähe GitHubi)
├── README.md
├── ulesanne03.md        SQL-päringud (Ülesanne 3)
├── ulesanne04.md        SQL-päringud (Ülesanne 4)
├── ylesanne07.md        JOIN-päringud (Ülesanne 7)
├── assets/
│   ├── css/             stiilifailid
│   └── images/          logod ja loomade pildid
├── admin/
│   ├── index.html       administraatori avaleht
│   ├── animals.html     loomade haldamise vaade
│   └── animal_add.html  looma lisamise ja muutmise vorm
├── database/
│   ├── kapakodu.sql     andmebaasi varukoopia (praegune seis)
│   ├── kapakodu_ul2.sql Ülesanne 2 varukoopia
│   └── kapakodu_ul6.sql Ülesanne 6 varukoopia
└── docs/
    └── ulesanne05_er.pdf  ER-diagramm
```
## Andmebaas

Andmebaas `kapakodu` koosneb tabelitest `liigid`, `toud`, `tootajad`, `loomad` ja `paringud`. Tabelite vahel on võõrvõtmed (`ON DELETE RESTRICT`, `ON UPDATE CASCADE`).

Taastamine:

```bash
sudo mysql -e "CREATE DATABASE kapakodu CHARACTER SET utf8mb4"
sudo mysql kapakodu < database/kapakodu.sql
```

## Käivitamine

1. Paigalda Apache, PHP 8.2 (`php8.2-mysql`) ja MariaDB.
2. Kopeeri projekt kausta `/var/www/html/kapakodu`.
3. Taasta andmebaas (vt eespool) ja loo andmebaasi kasutaja.
4. Kopeeri `config.example.php` nimega `config.php` ning kirjuta sinna oma andmebaasi parool.
5. Ava brauseris `http://localhost/kapakodu/index.php`.

## Valideerimine

HTML-lehed tuleb kontrollida [W3C validaatoriga](https://validator.w3.org/).

## Hetkeseis

- Ülesanne 1: HTML/Bootstrap kujundus (avalik osa ja admin).
- Ülesanne 2: andmebaas ja tabel `loomad`, CSV import, varukoopia.
- Ülesanne 3-4: SQL-päringud (SELECT, UPDATE, DELETE, agregaadid).
- Ülesanne 5: ER-diagramm.
- Ülesanne 6: andmebaasi normaliseerimine, võõrvõtmed.
- Ülesanne 7: JOIN-päringud.
- Ülesanne 8: dünaamiline avaleht (`index.php`) ja detailvaade (`animal.php`) andmebaasist, ühendus failis `config.php`.

Loomade nimekiri, otsing, filtrid, vormide töötlemine, sisselogimine ja admini haldus lisatakse järgmistes ülesannetes.
