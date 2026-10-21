# Ülesanne 4 – SQL funktsioonid

**Autor:** Alina Dmytrenko, IS25
**Andmebaas:** kapakodu, **tabel:** loomad

## 1. Leia varjupaigas olevate loomade koguarv

**Selgitus:** Funktsioon COUNT(*) loendab tabeli kõik read ehk loomade koguarvu.

**SQL-päring:**

```sql
SELECT COUNT(*) AS loomade_koguarv FROM loomad;
```

**Tulemus:**

```
+-----------------+
| loomade_koguarv |
+-----------------+
|              21 |
+-----------------+
```

## 2. Leia koerte koguarv

**Selgitus:** Funktsioon COUNT(*) loendab ridu, mille liigiks on Koer. Tingimus seatakse WHERE abil.

**SQL-päring:**

```sql
SELECT COUNT(*) AS koerte_koguarv FROM loomad WHERE liik = 'Koer';
```

**Tulemus:**

```
+----------------+
| koerte_koguarv |
+----------------+
|             11 |
+----------------+
```

## 3. Leia kõigi loomade vanuste summa

**Selgitus:** Funktsioon SUM(vanus) liidab kokku kõigi loomade vanused.

**SQL-päring:**

```sql
SELECT SUM(vanus) AS vanuste_summa FROM loomad;
```

**Tulemus:**

```
+---------------+
| vanuste_summa |
+---------------+
|            84 |
+---------------+
```

## 4. Leia loomade keskmine vanus

**Selgitus:** Funktsioon AVG(vanus) arvutab kõigi loomade keskmise vanuse. ROUND(..., 2) ümardab tulemuse kahe komakohani.

**SQL-päring:**

```sql
SELECT ROUND(AVG(vanus), 2) AS keskmine_vanus FROM loomad;
```

**Tulemus:**

```
+----------------+
| keskmine_vanus |
+----------------+
|           4.00 |
+----------------+
```

## 5. Kuva, mitu looma on igast liigist

**Selgitus:** GROUP BY liik grupeerib loomad liigi järgi ning COUNT(*) loendab loomi igas grupis.

**SQL-päring:**

```sql
SELECT liik, COUNT(*) AS loomi FROM loomad GROUP BY liik;
```

**Tulemus:**

```
+----------+-------+
| liik     | loomi |
+----------+-------+
| Kass     |     9 |
| Koer     |    11 |
| Küülik   |     1 |
+----------+-------+
```

## 6. Kuva iga liigi keskmine vanus

**Selgitus:** GROUP BY liik grupeerib loomad liigi järgi ning AVG(vanus) arvutab igale liigile keskmise vanuse. ROUND(..., 2) ümardab tulemuse kahe komakohani.

**SQL-päring:**

```sql
SELECT liik, ROUND(AVG(vanus), 2) AS keskmine_vanus FROM loomad GROUP BY liik;
```

**Tulemus:**

```
+----------+----------------+
| liik     | keskmine_vanus |
+----------+----------------+
| Kass     |           3.67 |
| Koer     |           4.55 |
| Küülik   |           1.00 |
+----------+----------------+
```

## 7. Kuva, mitu looma on igas staatuses

**Selgitus:** GROUP BY staatus grupeerib loomad staatuse järgi ning COUNT(*) loendab loomi igas staatuses.

**SQL-päring:**

```sql
SELECT staatus, COUNT(*) AS loomi FROM loomad GROUP BY staatus;
```

**Tulemus:**

```
+-------------+-------+
| staatus     | loomi |
+-------------+-------+
| saadaval    |    12 |
| broneeritud |     5 |
| hoolduses   |     4 |
+-------------+-------+
```

## 8. Kuva ainult need staatused, kus on vähemalt kolm looma

**Selgitus:** GROUP BY staatus grupeerib loomad staatuse järgi. HAVING COUNT(*) >= 3 jätab alles ainult need grupid, kus on vähemalt kolm looma. HAVING kasutatakse WHERE asemel, sest tingimus käib grupeeritud tulemuse kohta.

**SQL-päring:**

```sql
SELECT staatus, COUNT(*) AS loomi FROM loomad GROUP BY staatus HAVING COUNT(*) >= 3;
```

**Tulemus:**

```
+-------------+-------+
| staatus     | loomi |
+-------------+-------+
| saadaval    |    12 |
| broneeritud |     5 |
| hoolduses   |     4 |
+-------------+-------+
```
