# Alina Käpakodu

**Autor:** Alina Dmytrenko, IS25
**Kursus:** PHP ja MySQL veebirakenduste loomine

## Kirjeldus

Käpakodu on loomade varjupaiga veebirakendus. Külastajad saavad vaadata, otsida ja filtreerida varjupaiga loomi ning saata päringuid. Töötajad logivad sisse ja haldavad loomi admin-paneelis (lisamine, muutmine, kustutamine).

## Kasutatud tehnoloogiad

- HTML5, CSS3
- [Bootstrap 5](https://getbootstrap.com/) (komponendid ja paigutus)
- [Font Awesome](https://fontawesome.com/) (ikoonid)
- PHP 8.2 (mysqli, fileinfo, Prepared Statements, sessioonid)
- MariaDB 10.11 (MySQL)
- Apache 2.4
- Git ja GitHub

## Projekti struktuur

```
kapakodu/
├── index.php            avaleht (4 viimati lisatud looma andmebaasist)
├── all_animals.php      kõik loomad, otsing ja filtrid (GET)
├── animal.php           looma detailvaade (animal.php?id=...)
├── contact.php          kontaktivorm (salvestab tabelisse paringud)
├── login.php            sisselogimine (sessioon, password_verify, meelespea küpsis)
├── logout.php           väljalogimine
├── header.php           ühine päis, menüü tabelist menu
├── footer.php           ühine jalus
├── breadcrumbs.php      leivapuru navigatsioon
├── config.example.php   andmebaasi seadete näidis
├── .gitignore           (config.php ei lähe GitHubi)
├── README.md
├── ulesanne03.md        SQL-päringud (Ülesanne 3)
├── ulesanne04.md        SQL-päringud (Ülesanne 4)
├── ylesanne07.md        JOIN-päringud (Ülesanne 7)
├── assets/
│   ├── css/             stiilifailid
│   └── images/          logod ja loomade pildid (sh üleslaetud)
├── admin/
│   ├── includes/        config.php (ligipääsu kontroll), header.php, footer.php
│   ├── index.php        administraatori avaleht (statistika)
│   ├── animals.php      loomade nimekiri lehekülgedega
│   ├── animal_add.php   looma lisamine ja pildi üleslaadimine
│   ├── animal_edit.php  looma andmete muutmine
│   └── animal_delete.php  looma kustutamine (POST)
├── database/
│   ├── kapakodu.sql     andmebaasi varukoopia (praegune seis)
│   ├── kapakodu_ul2.sql Ülesanne 2 varukoopia
│   └── kapakodu_ul6.sql Ülesanne 6 varukoopia
└── docs/
    └── ulesanne05_er.pdf  ER-diagramm
```

## Andmebaas

Andmebaas `kapakodu` koosneb tabelitest `liigid`, `toud`, `tootajad`, `loomad`, `paringud` ja `menu`.

- `liigid`, `toud`: loomaliigid ja tõud
- `tootajad`: töötajad (e-post on unikaalne, parool salvestatakse `password_hash()` räsina)
- `loomad`: varjupaiga loomad (viited liigile, tõule ja töötajale)
- `paringud`: kontaktivormi sõnumid (võib viidata loomale)
- `menu`: avaliku saidi menüü

Tabelite vahel on võõrvõtmed (`ON DELETE RESTRICT`, `ON UPDATE CASCADE`). Seetõttu ei saa kustutada looma, millega on seotud päring.

Taastamine:

```bash
sudo mysql -e "CREATE DATABASE kapakodu CHARACTER SET utf8mb4"
sudo mysql kapakodu < database/kapakodu.sql
```

## Käivitamine

1. Paigalda Apache, PHP 8.2 (`php8.2-mysql`, `fileinfo`) ja MariaDB.
2. Kopeeri projekt kausta `/var/www/html/kapakodu`.
3. Taasta andmebaas (vt eespool) ja loo andmebaasi kasutaja.
4. Kopeeri `config.example.php` nimega `config.php` ning kirjuta sinna oma andmebaasi parool.
5. Anna Apache'ile (`www-data`) kirjutusõigus kaustale `assets/images` (piltide üleslaadimine).
6. Ava brauseris `http://localhost/kapakodu/index.php`.
7. Admin-paneel: `http://localhost/kapakodu/login.php`. Ilma sisselogimiseta suunatakse admin-lehed login.php lehele.

## Valideerimine

HTML-lehed tuleb kontrollida [W3C validaatoriga](https://validator.w3.org/).

## Hetkeseis

- Ülesanne 1: HTML/Bootstrap kujundus (avalik osa ja admin).
- Ülesanne 2: andmebaas ja tabel `loomad`, CSV import, varukoopia.
- Ülesanne 3-4: SQL-päringud (SELECT, UPDATE, DELETE, agregaadid).
- Ülesanne 5: ER-diagramm.
- Ülesanne 6: andmebaasi normaliseerimine, võõrvõtmed.
- Ülesanne 7: JOIN-päringud.
- Ülesanne 8: dünaamiline avaleht ja detailvaade andmebaasist, ühendus failis `config.php`.
- Ülesanne 9: loomade nimekiri, otsing ja filtrid (GET, prepared statement).
- Ülesanne 10: navigeerimine (tabel `menu`, `header.php`, `footer.php`, `breadcrumbs.php`).
- Ülesanne 11: kontaktivorm salvestab sõnumid tabelisse `paringud`.
- Ülesanne 12: admin-paneel loeb andmed andmebaasist, looma kustutamine.
- Ülesanne 13: looma lisamise vorm, vormi kontroll, pildi üleslaadimine.
- Ülesanne 14: looma andmete muutmise vorm.
- Ülesanne 15: loomade nimekirja lehekülgede jaotus.
- Ülesanne 16-18: töötajate tabel sisselogimiseks, sisse- ja väljalogimine, admin-lehtede kaitse, "jäta mind meelde" küpsis.
