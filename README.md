[README.md](https://github.com/user-attachments/files/33757996/README.md)
# Alina Käpakodu

**Autor:** Alina Dmytrenko, IS25
**Kursus:** PHP ja MySQL veebirakenduste loomine
**Ülesanne 01:** Projekti ettevalmistamine ja kasutajaliidese loomine

## Kirjeldus

Käpakodu on loomade varjupaiga veebirakendus, mis võimaldab külastajatel tutvuda varjupaigas olevate loomadega ning administraatoril hallata kogu varjupaiga infot.

Praegu on valmis rakenduse kasutajaliides (HTML, CSS ja Bootstrap). PHP-d ja andmebaasi ei kasutata veel, need lisatakse järgmistes peatükkides.

## Kasutatud tehnoloogiad

- HTML5
- CSS3
- [Bootstrap 5](https://getbootstrap.com/) (komponendid ja paigutus)
- [Font Awesome](https://fontawesome.com/) (ikoonid)
- Git ja GitHub

## Projekti struktuur

```
kapakodu/
├── index.html          avaleht
├── all_animals.html    kõik loomad (otsing ja filter)
├── animal.html         looma detailvaade
├── contact.html        kontaktileht
├── login.html          sisselogimisleht
├── README.md
├── assets/
│   ├── css/            stiilifailid
│   └── images/         logod ja loomade pildid
├── admin/
│   ├── index.html      administraatori avaleht
│   ├── animals.html    loomade haldamise vaade
│   └── animal_add.html looma lisamise ja muutmise vorm
└── database/
    └── kapakodu.sql    andmebaasi varukoopia
```

## Käivitamine

1. Laadi projekt alla (`git clone` või ZIP-fail GitHubist).
2. Ava soovitud HTML-fail (nt `index.html`) brauseris.

Serverit ega andmebaasi pole vaja. Bootstrap ja Font Awesome laaditakse internetist, seega vajalik on internetiühendus.

## Valideerimine

Kõik HTML-lehed on kontrollitud [W3C validaatoriga](https://validator.w3.org/).

## Hindamismudel

### Front-end ehk avalik osa

- [x] Veebirakendusel on avaleht, kus kuvatakse loomade nimekiri koos piltidega
- [ ] Loomi saab otsida nime järgi
- [ ] Loomi saab filtreerida
- [x] Looma valimisel kuvatakse tema detailvaade
- [ ] Külastaja saab saata päringu kontaktivormi kaudu
- [x] Veebirakendus kohandub erinevate ekraanisuurustega
- [ ] Veebivormid sisaldavad kliendipoolset valideerimist

### Back-end ehk haldus

- [ ] Administraator saab sisse logida
- [ ] Administraator saab hallata loomade andmeid (lisada, muuta ja kustutada CRUD)
- [ ] Administraator saab hallata liikide andmeid
- [ ] Administraator saab hallata tõugude andmeid
- [ ] Administraator saab hallata kasutajate andmeid
- [ ] Administraator saab hallata saabunud kontaktipäringuid
- [ ] Administraator näeb veebirakenduse statistikat

### Tehnilised nõuded

- [x] Veebirakendus kasutab HTML-i, CSS-i ja Bootstrapi
- [ ] Veebirakendus kasutab PHP-d andmete töötlemiseks
- [ ] Andmed salvestatakse MySQL andmebaasi
- [x] Veebirakendus kohandub erinevate ekraanisuurustega (responsive disain)
- [ ] Veebivormid sisaldavad kliendipoolset valideerimist
- [ ] Veebirakendus järgib kursuse jooksul õpitud turvalise programmeerimise põhimõtteid
- [x] Lähtekood on korrektselt struktureeritud ja loetav
- [x] Projekt on hallatud Gitiga ja üles laaditud GitHubi
- [x] Projekt sisaldab ajakohast README.md faili

## Hetkeseis

Ülesanne 01 raames on valminud kõik avalikud ja halduse vaated ühtse kujundusega. Otsing, filtrid, vormide töötlemine, sisselogimine ja andmete haldamine lisatakse järgmistes peatükkides PHP ja MySQL abil.
