# Ülesanne 7 – Tabelite ühendamine

**Autor:** Alina Dmytrenko, IS25
**Andmebaas:** kapakodu

## 1. Kuva kõik loomad koos nende liigi ja tõu nimetusega

**Selgitus:** INNER JOIN ühendab loomad liikide ja tõugudega võõrvõtmete liik_id ja toug_id kaudu.

**SQL-päring:**

```sql
SELECT l.id, l.nimi, g.nimetus AS liik, t.nimetus AS tou
FROM loomad l
JOIN liigid g ON g.id = l.liik_id
JOIN toud t ON t.id = l.toug_id;
```

**Tulemus:**

```
+----+--------+----------+------------------------+
| id | nimi   | liik     | tou                    |
+----+--------+----------+------------------------+
|  3 | Rex    | Koer     | Labrador               |
|  5 | Bruno  | Koer     | Saksa lambakoer        |
|  1 | Pontu  | Koer     | Segavereline           |
|  6 | Bella  | Koer     | Segavereline           |
|  9 | Musti  | Koer     | Segavereline           |
| 10 | Lotte  | Koer     | Segavereline           |
| 13 | Roki   | Koer     | Segavereline           |
| 15 | Marta  | Koer     | Segavereline           |
| 17 | Bobby  | Koer     | Segavereline           |
| 19 | Rufi   | Koer     | Segavereline           |
| 20 | Muri   | Koer     | Segavereline           |
|  7 | Miisu  | Kass     | Euroopa lühikarvaline  |
|  8 | Nurr   | Kass     | Euroopa lühikarvaline  |
| 11 | Pätu   | Kass     | Euroopa lühikarvaline  |
| 14 | Lumi   | Kass     | Euroopa lühikarvaline  |
| 16 | Simba  | Kass     | Euroopa lühikarvaline  |
| 21 | Triibu | Kass     | Euroopa lühikarvaline  |
| 22 | Sipsik | Kass     | Euroopa lühikarvaline  |
|  4 | Mimi   | Kass     | Siiami                 |
| 18 | Kiisu  | Kass     | Maine Coon             |
| 12 | Kribu  | Küülik   | Päkapikk-küülik        |
+----+--------+----------+------------------------+
```

## 2. Kuva kõik loomad koos vastutava töötaja nimega

**Selgitus:** JOIN ühendab loomad töötajatega võõrvõtme tootaja_id kaudu ning kuvab töötaja nime.

**SQL-päring:**

```sql
SELECT l.id, l.nimi, w.nimi AS tootaja
FROM loomad l
JOIN tootajad w ON w.id = l.tootaja_id;
```

**Tulemus:**

```
+----+--------+-----------------+
| id | nimi   | tootaja         |
+----+--------+-----------------+
|  4 | Mimi   | Alina Dmytrenko |
|  6 | Bella  | Alina Dmytrenko |
|  8 | Nurr   | Alina Dmytrenko |
| 10 | Lotte  | Alina Dmytrenko |
| 12 | Kribu  | Alina Dmytrenko |
| 14 | Lumi   | Alina Dmytrenko |
| 16 | Simba  | Alina Dmytrenko |
| 18 | Kiisu  | Alina Dmytrenko |
| 20 | Muri   | Alina Dmytrenko |
| 22 | Sipsik | Alina Dmytrenko |
|  1 | Pontu  | Mari Tamm       |
|  3 | Rex    | Mari Tamm       |
|  5 | Bruno  | Mari Tamm       |
|  7 | Miisu  | Mari Tamm       |
|  9 | Musti  | Mari Tamm       |
| 11 | Pätu   | Mari Tamm       |
| 13 | Roki   | Mari Tamm       |
| 15 | Marta  | Mari Tamm       |
| 17 | Bobby  | Mari Tamm       |
| 19 | Rufi   | Mari Tamm       |
| 21 | Triibu | Mari Tamm       |
+----+--------+-----------------+
```

## 3. Kuva kõik saadaval olevad loomad koos liigi nimetusega

**Selgitus:** Päring ühendab loomad liikidega ja filtreerib WHERE abil ainult staatusega saadaval loomad.

**SQL-päring:**

```sql
SELECT l.id, l.nimi, g.nimetus AS liik, l.staatus
FROM loomad l
JOIN liigid g ON g.id = l.liik_id
WHERE l.staatus = 'saadaval';
```

**Tulemus:**

```
+----+--------+----------+----------+
| id | nimi   | liik     | staatus  |
+----+--------+----------+----------+
|  3 | Rex    | Koer     | saadaval |
|  6 | Bella  | Koer     | saadaval |
|  9 | Musti  | Koer     | saadaval |
| 10 | Lotte  | Koer     | saadaval |
| 19 | Rufi   | Koer     | saadaval |
|  4 | Mimi   | Kass     | saadaval |
| 11 | Pätu   | Kass     | saadaval |
| 14 | Lumi   | Kass     | saadaval |
| 16 | Simba  | Kass     | saadaval |
| 18 | Kiisu  | Kass     | saadaval |
| 22 | Sipsik | Kass     | saadaval |
| 12 | Kribu  | Küülik   | saadaval |
+----+--------+----------+----------+
```

## 4. Kuva kõik loomad tähestikulises järjekorras koos liigi nimetusega

**Selgitus:** Päring kasutab tabeli aliaseid (l ja g) ning sorteerib loomad nime järgi ORDER BY abil.

**SQL-päring:**

```sql
SELECT l.nimi, g.nimetus AS liik
FROM loomad l
JOIN liigid g ON g.id = l.liik_id
ORDER BY l.nimi ASC;
```

**Tulemus:**

```
+--------+----------+
| nimi   | liik     |
+--------+----------+
| Bella  | Koer     |
| Bobby  | Koer     |
| Bruno  | Koer     |
| Kiisu  | Kass     |
| Kribu  | Küülik   |
| Lotte  | Koer     |
| Lumi   | Kass     |
| Marta  | Koer     |
| Miisu  | Kass     |
| Mimi   | Kass     |
| Muri   | Koer     |
| Musti  | Koer     |
| Nurr   | Kass     |
| Pätu   | Kass     |
| Pontu  | Koer     |
| Rex    | Koer     |
| Roki   | Koer     |
| Rufi   | Koer     |
| Simba  | Kass     |
| Sipsik | Kass     |
| Triibu | Kass     |
+--------+----------+
```

## 5. Kasuta LEFT JOIN-i ja kuva kõik loomad koos vastutava töötaja nimega

**Selgitus:** LEFT JOIN kuvab kõik loomad ka siis, kui neil puudub töötaja. Sellisel juhul on töötaja nimi NULL.

**SQL-päring:**

```sql
SELECT l.id, l.nimi, w.nimi AS tootaja
FROM loomad l
LEFT JOIN tootajad w ON w.id = l.tootaja_id;
```

**Tulemus:**

```
+----+--------+-----------------+
| id | nimi   | tootaja         |
+----+--------+-----------------+
|  1 | Pontu  | Mari Tamm       |
|  3 | Rex    | Mari Tamm       |
|  4 | Mimi   | Alina Dmytrenko |
|  5 | Bruno  | Mari Tamm       |
|  6 | Bella  | Alina Dmytrenko |
|  7 | Miisu  | Mari Tamm       |
|  8 | Nurr   | Alina Dmytrenko |
|  9 | Musti  | Mari Tamm       |
| 10 | Lotte  | Alina Dmytrenko |
| 11 | Pätu   | Mari Tamm       |
| 12 | Kribu  | Alina Dmytrenko |
| 13 | Roki   | Mari Tamm       |
| 14 | Lumi   | Alina Dmytrenko |
| 15 | Marta  | Mari Tamm       |
| 16 | Simba  | Alina Dmytrenko |
| 17 | Bobby  | Mari Tamm       |
| 18 | Kiisu  | Alina Dmytrenko |
| 19 | Rufi   | Mari Tamm       |
| 20 | Muri   | Alina Dmytrenko |
| 21 | Triibu | Mari Tamm       |
| 22 | Sipsik | Alina Dmytrenko |
+----+--------+-----------------+
```

## 6. Kuva loomade nimed ja nende liigid alampäringu abil

**Selgitus:** SELECT-i sees olev alampäring leiab igale loomale tema liigi nimetuse tabelist liigid.

**SQL-päring:**

```sql
SELECT l.nimi,
       (SELECT g.nimetus FROM liigid g WHERE g.id = l.liik_id) AS liik
FROM loomad l;
```

**Tulemus:**

```
+--------+----------+
| nimi   | liik     |
+--------+----------+
| Pontu  | Koer     |
| Rex    | Koer     |
| Mimi   | Kass     |
| Bruno  | Koer     |
| Bella  | Koer     |
| Miisu  | Kass     |
| Nurr   | Kass     |
| Musti  | Koer     |
| Lotte  | Koer     |
| Pätu   | Kass     |
| Kribu  | Küülik   |
| Roki   | Koer     |
| Lumi   | Kass     |
| Marta  | Koer     |
| Simba  | Kass     |
| Bobby  | Koer     |
| Kiisu  | Kass     |
| Rufi   | Koer     |
| Muri   | Koer     |
| Triibu | Kass     |
| Sipsik | Kass     |
+--------+----------+
```

## 7. Iga töötaja nimi, tema vastutusel olevate loomade arv ja loomade nimed ühel real

**Selgitus:** COUNT loendab töötaja loomi ja GROUP_CONCAT paneb loomade nimed ühele reale. LEFT JOIN toob välja ka töötajad, kellel loomi pole.

**SQL-päring:**

```sql
SELECT w.nimi AS tootaja,
       COUNT(l.id) AS loomade_arv,
       GROUP_CONCAT(l.nimi ORDER BY l.nimi SEPARATOR ', ') AS loomad
FROM tootajad w
LEFT JOIN loomad l ON l.tootaja_id = w.id
GROUP BY w.id, w.nimi;
```

**Tulemus:**

```
+-----------------+-------------+--------------------------------------------------------------------------+
| tootaja         | loomade_arv | loomad                                                                   |
+-----------------+-------------+--------------------------------------------------------------------------+
| Alina Dmytrenko |          10 | Bella, Kiisu, Kribu, Lotte, Lumi, Mimi, Muri, Nurr, Simba, Sipsik        |
| Mari Tamm       |          11 | Bobby, Bruno, Marta, Miisu, Musti, Pätu, Pontu, Rex, Roki, Rufi, Triibu  |
+-----------------+-------------+--------------------------------------------------------------------------+
```
