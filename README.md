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
