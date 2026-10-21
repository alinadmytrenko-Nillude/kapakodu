# Ülesanne 3 – SQL-päringud

**Autor:** Alina Dmytrenko, IS25
**Andmebaas:** kapakodu, **tabel:** loomad

## 1. Kuva kõik loomad

**Selgitus:** Päring toob tabelist loomad kõik read ja kõik veerud.

**SQL-päring:**

```sql
SELECT * FROM loomad;
```

**Tulemus:**
```
+----+--------+----------+-------+-------+--------------+----------+------------+------------+-----------------------------------+-------------------------------------------------------+------------+-------------+-----------------+-------------+------------+
| id | nimi   | liik     | sugu  | vanus | sunnikuupaev | suurus   | varvus     | asukoht    | luhikirjeldus                     | kirjeldus                                             | pilt       | staatus     | steriliseeritud | kiibistatud | lisatud    |
+----+--------+----------+-------+-------+--------------+----------+------------+------------+-----------------------------------+-------------------------------------------------------+------------+-------------+-----------------+-------------+------------+
|  1 | Pontu  | Koer     | isane |     3 | 2023-04-10   | keskmine | Pruun      | Tallinn    | Sõbralik ja mänguhimuline koer.   | Pontu armastab jalutamist ja mängimist.               | pontu.jpg  | saadaval    |               1 |           1 | 2026-10-21 |
|  2 | Murka  | Kass     | emane |     2 | 2024-06-15   | väike    | Hall       | Tartu      | Rahulik ja kodune kass.           | Murka on vaikne seltsiline, kes otsib rahulikku kodu. | murka.jpg  | saadaval    |               1 |           0 | 2026-10-21 |
|  3 | Rex    | Koer     | isane |     2 | 2023-05-12   | keskmine | Kuldne     | Tallinn    | Sõbralik koer                     | Energiat täis ja armastab jalutuskäike.               | rex.jpg    | saadaval    |               1 |           1 | 2026-07-01 |
|  4 | Mimi   | Kass     | emane |     6 | 2020-08-14   | väike    | Hall-valge | Tartu      | Rahulik kass                      | Väga sõbralik ning naudib inimese seltskonda.         | mimi.jpg   | saadaval    |               1 |           1 | 2026-07-02 |
|  5 | Bruno  | Koer     | isane |     5 | 2021-01-22   | suur     | Pruun      | Pärnu      | Valvekoer                         | Rahulik ja ustav perekoer.                            | bruno.jpg  | broneeritud |               1 |           1 | 2026-07-03 |
|  6 | Bella  | Koer     | emane |     1 | 2025-02-18   | keskmine | Must       | Haapsalu   | Mänguhimuline                     | Noor ja aktiivne koer.                                | bella.jpg  | saadaval    |               0 |           1 | 2026-07-04 |
|  7 | Miisu  | Kass     | emane |     4 | 2022-06-30   | väike    | Triibuline | Viljandi   | Uudishimulik kass                 | Armastab ronida ja mängida.                           | miisu.jpg  | broneeritud |               1 |           1 | 2026-07-05 |
|  8 | Nurr   | Kass     | isane |     3 | 2023-03-10   | väike    | Hall       | Rakvere    | Vaikne kass                       | Sobib rahulikku koju.                                 | nurr.jpg   | hoolduses   |               1 |           0 | 2026-07-06 |
|  9 | Musti  | Koer     | isane |     3 | 2022-04-01   | keskmine | Pruun-must | Tallinn    | Rõõmsameelne                      | Naudib pikki jalutuskäike.                            | musti.jpg  | saadaval    |               1 |           1 | 2026-07-07 |
| 10 | Lotte  | Koer     | emane |     7 | 2019-09-19   | keskmine | Beež       | Narva      | Rahulik                           | Väga sõbralik vanem koer.                             | lotte.jpg  | saadaval    |               1 |           1 | 2026-07-08 |
| 11 | Pätu   | Kass     | isane |     2 | 2024-02-11   | väike    | Must       | Jõhvi      | Mänguline                         | Armastab pallidega mängida.                           | patu.jpg   | saadaval    |               0 |           1 | 2026-07-09 |
| 12 | Kribu  | Küülik   | emane |     1 | 2025-01-15   | väike    | Valge      | Tallinn    | Armas küülik                      | Harjunud inimestega.                                  | kribu.jpg  | saadaval    |               0 |           0 | 2026-07-10 |
| 13 | Roki   | Koer     | isane |     8 | 2018-07-07   | suur     | Must       | Tartu      | Kogenud sõber                     | Rahulik ja kuulekas.                                  | roki.jpg   | hoolduses   |               1 |           1 | 2026-07-11 |
| 14 | Lumi   | Kass     | emane |     5 | 2021-12-24   | väike    | Valge      | Pärnu      | Hellik                            | Naudib pai tegemist.                                  | lumi.jpg   | saadaval    |               1 |           1 | 2026-07-12 |
| 15 | Marta  | Koer     | emane |     4 | 2022-10-09   | keskmine | Pruun      | Rapla      | Sõbralik                          | Sobib lastega perre.                                  | marta.jpg  | broneeritud |               1 |           1 | 2026-07-13 |
| 16 | Simba  | Kass     | isane |     2 | 2024-01-08   | väike    | Oranž      | Valga      | Julge                             | Väga uudishimulik kass.                               | simba.jpg  | saadaval    |               1 |           0 | 2026-07-14 |
| 17 | Bobby  | Koer     | isane |     6 | 2020-05-03   | suur     | Must-valge | Võru       | Truu kaaslane                     | Armastab õues joosta.                                 | bobby.jpg  | hoolduses   |               1 |           1 | 2026-07-15 |
| 18 | Kiisu  | Kass     | emane |     1 | 2025-03-14   | väike    | Kilpkonn   | Paide      | Noor kass                         | Õpib alles maailma tundma.                            | kiisu.jpg  | saadaval    |               0 |           1 | 2026-07-16 |
| 19 | Rufi   | Koer     | isane |     2 | 2023-08-18   | keskmine | Hall       | Kuressaare | Aktiivne                          | Sobib sportlikule perele.                             | rufi.jpg   | saadaval    |               0 |           1 | 2026-07-17 |
| 20 | Muri   | Koer     | emane |     9 | 2017-11-11   | suur     | Must       | Tallinn    | Rahulik                           | Vajab rahulikku kodu.                                 | muri.jpg   | hoolduses   |               1 |           1 | 2026-07-18 |
| 21 | Triibu | Kass     | isane |     7 | 2019-04-20   | väike    | Triibuline | Põlva      | Tasane                            | Meeldib aknal istuda.                                 | triibu.jpg | broneeritud |               1 |           1 | 2026-07-19 |
| 22 | Sipsik | Kass     | emane |     3 | 2023-06-06   | väike    | Must-valge | Keila      | Seltskondlik                      | Naudib mängimist ja tähelepanu.                       | sipsik.jpg | saadaval    |               1 |           1 | 2026-07-20 |
+----+--------+----------+-------+-------+--------------+----------+------------+------------+-----------------------------------+-------------------------------------------------------+------------+-------------+-----------------+-------------+------------+
```
## 2. Kuva ühe looma kõik andmed tema nime järgi

**Selgitus:** Päring otsib looma nime järgi (näiteks Rex) ja kuvab selle looma kõik andmed.

**SQL-päring:**

```sql
SELECT * FROM loomad WHERE nimi = 'Rex';
```

**Tulemus:**

```
+----+------+------+-------+-------+--------------+----------+--------+---------+----------------+-------------------------------------------+---------+----------+-----------------+-------------+------------+
| id | nimi | liik | sugu  | vanus | sunnikuupaev | suurus   | varvus | asukoht | luhikirjeldus  | kirjeldus                                 | pilt    | staatus  | steriliseeritud | kiibistatud | lisatud    |
+----+------+------+-------+-------+--------------+----------+--------+---------+----------------+-------------------------------------------+---------+----------+-----------------+-------------+------------+
|  3 | Rex  | Koer | isane |     2 | 2023-05-12   | keskmine | Kuldne | Tallinn | Sõbralik koer  | Energiat täis ja armastab jalutuskäike.   | rex.jpg | saadaval |               1 |           1 | 2026-07-01 |
+----+------+------+-------+-------+--------------+----------+--------+---------+----------------+-------------------------------------------+---------+----------+-----------------+-------------+------------+

```

## 3. Kuva kõik vähemalt viieaastased loomad

**Selgitus:** Päring valib loomad, kelle vanus on 5 aastat või rohkem.

**SQL-päring:**

```sql
SELECT id, nimi, liik, vanus FROM loomad WHERE vanus >= 5;
```

**Tulemus:**

```
+----+--------+------+-------+
| id | nimi   | liik | vanus |
+----+--------+------+-------+
|  4 | Mimi   | Kass |     6 |
|  5 | Bruno  | Koer |     5 |
| 10 | Lotte  | Koer |     7 |
| 13 | Roki   | Koer |     8 |
| 14 | Lumi   | Kass |     5 |
| 17 | Bobby  | Koer |     6 |
| 20 | Muri   | Koer |     9 |
| 21 | Triibu | Kass |     7 |
+----+--------+------+-------+
```

## 4. Kuva kõik loomad, kelle nimi algab M-tähega

**Selgitus:** Päring kasutab LIKE operaatorit, et leida loomad, kelle nimi algab tähega M.

**SQL-päring:**

```sql
SELECT id, nimi, liik FROM loomad WHERE nimi LIKE 'M%';
```

**Tulemus:**

```
+----+-------+------+
| id | nimi  | liik |
+----+-------+------+
|  2 | Murka | Kass |
|  4 | Mimi  | Kass |
|  7 | Miisu | Kass |
|  9 | Musti | Koer |
| 15 | Marta | Koer |
| 20 | Muri  | Koer |
+----+-------+------+
```

## 5. Kuva kõik saadaval olevad loomad tähestikulises järjekorras

**Selgitus:** Päring valib loomad staatusega saadaval ja sorteerib need nime järgi tähestikulises järjekorras.

**SQL-päring:**

```sql
SELECT id, nimi, liik, staatus FROM loomad WHERE staatus = 'saadaval' ORDER BY nimi ASC;
```

**Tulemus:**

```
+----+--------+----------+----------+
| id | nimi   | liik     | staatus  |
+----+--------+----------+----------+
|  6 | Bella  | Koer     | saadaval |
| 18 | Kiisu  | Kass     | saadaval |
| 12 | Kribu  | Küülik   | saadaval |
| 10 | Lotte  | Koer     | saadaval |
| 14 | Lumi   | Kass     | saadaval |
|  4 | Mimi   | Kass     | saadaval |
|  2 | Murka  | Kass     | saadaval |
|  9 | Musti  | Koer     | saadaval |
| 11 | Pätu   | Kass     | saadaval |
|  1 | Pontu  | Koer     | saadaval |
|  3 | Rex    | Koer     | saadaval |
| 19 | Rufi   | Koer     | saadaval |
| 16 | Simba  | Kass     | saadaval |
| 22 | Sipsik | Kass     | saadaval |
+----+--------+----------+----------+
```

## 6. Kuva kolm kõige vanemat looma

**Selgitus:** Päring sorteerib loomad vanuse järgi kahanevalt ja piirab tulemuse kolme esimese reaga.

**SQL-päring:**

```sql
SELECT id, nimi, liik, vanus FROM loomad ORDER BY vanus DESC LIMIT 3;
```

**Tulemus:**

```
+----+-------+------+-------+
| id | nimi  | liik | vanus |
+----+-------+------+-------+
| 20 | Muri  | Koer |     9 |
| 13 | Roki  | Koer |     8 |
| 10 | Lotte | Koer |     7 |
+----+-------+------+-------+
```

## 6. Kuva kolm kõige vanemat looma

**Selgitus:** Päring sorteerib loomad vanuse järgi kahanevalt ja piirab tulemuse kolme esimese reaga.

**SQL-päring:**

```sql
SELECT id, nimi, liik, vanus FROM loomad ORDER BY vanus DESC LIMIT 3;
```

**Tulemus:**

```
+----+-------+------+-------+
| id | nimi  | liik | vanus |
+----+-------+------+-------+
| 20 | Muri  | Koer |     9 |
| 13 | Roki  | Koer |     8 |
| 10 | Lotte | Koer |     7 |
+----+-------+------+-------+
```

## 7. Muuda ühe looma staatuse väärtuseks broneeritud

**Selgitus:** Päring muudab looma Pontu (id = 1) staatuse väärtuseks broneeritud. Enne ja pärast muutmist kontrollitakse tulemust SELECT päringuga.

**SQL-päring:**

```sql
SELECT id, nimi, staatus FROM loomad WHERE id = 1;

UPDATE loomad SET staatus = 'broneeritud' WHERE id = 1;

SELECT id, nimi, staatus FROM loomad WHERE id = 1;
```

**Tulemus enne muutmist:**

```
+----+-------+----------+
| id | nimi  | staatus  |
+----+-------+----------+
|  1 | Pontu | saadaval |
+----+-------+----------+
```

**Tulemus pärast muutmist:**

```
+----+-------+-------------+
| id | nimi  | staatus     |
+----+-------+-------------+
|  1 | Pontu | broneeritud |
+----+-------+-------------+
```

## 8. Kustuta vabalt valitud ID-ga loom

**Selgitus:** Päring kustutab looma, kelle id on 2 (Murka). Enne ja pärast kustutamist kontrollitakse tulemust SELECT päringuga.

**SQL-päring:**

```sql
SELECT id, nimi FROM loomad WHERE id = 2;

DELETE FROM loomad WHERE id = 2;

SELECT id, nimi FROM loomad WHERE id = 2;
```

**Tulemus enne kustutamist:**

```
+----+-------+
| id | nimi  |
+----+-------+
|  2 | Murka |
+----+-------+
```

**Tulemus pärast kustutamist:**

```
+-------------+
| loomi_kokku |
+-------------+
|          21 |
+-------------+
```
