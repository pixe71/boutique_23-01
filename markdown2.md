# 📊BDD Boutique

## 📄Introduction

Cette base de données est dédiée à la gestion des produits, des commandes et des utilisateurs pour une boutique en ligne. Ce document présente la structure de la base de données, les relations entre les différents programmes et les bonnes pratiques pour l'exploitation des données.

## 📅Tables des matières

* <a href="#P1">📂Chemin d'accès</a>
* <a href="#P2">💻Produits</a>
* <a href="#P3">💡Utiles</a>

<a id="P1"></a>

## 📂 Chemin d'accès

┣ 📂 boutique \
┃ ┣ 📂 img \
┃ ┃ ┣ 🖼 *[pc1.png](/boutique/img/pc1.png)* \
┃ ┃ ┣ 🖼 *[pc2.png](/boutique/img/pc2.png)* \
┃ ┃ ┣ 🖼 *[pc3.png](/boutique/img/pc3.png)* \
┃ ┃ ┣ 🖼 *[pc4.png](/boutique/img/pc4.png)* \
┃ ┣ 📂 sql \
┃ ┃ ┣ 📜 *[boutique.sql](/boutique/sql/boutique.sql)* \
┃ ┣ 📂 sty \
┃ ┃ ┣ 📜 *[connexion.css](/boutique/sty/connexion.css)* \
┃ ┃ ┣ 📜 *[inscription.css](/boutique/sty/inscription.css)* \
┃ ┃ ┣ 📜 *[panier.css](/boutique/sty/panier.css)* \
┃ ┃ ┣ 📜 *[style.css](/boutique/sty/style.css)* \
┃ ┃ ┣ 📜 *[ventes.css](/boutique/sty/ventes.css)* \
┃ ┣ 📜 *[connexion.php](/boutique/connexion.php)* \
┃ ┣ 📜 *[index.php](/boutique/index.php)* \
┃ ┣ 📜 *[inscription.php](/boutique/inscription.php)* \
┃ ┣ 📜 *[panier.php](/boutique/panier.php)* \
┃ ┣ 📜 *[ventes.php](/boutique/ventes.php)* \
┗

<a id="P2"></a>

# 💻Produit

| Titre | prix (€) | Ref | Description | Photo
| --------- | --------- | --------- | -------- | -------- | 
| Asus ROG | 499.99 | ORDI1 | Intel i9, 16 G RAM, Stockage 1 TO, RTX 3080 | ![image](boutique/img/pc1.png)
| Lenovo | 599.99 | ORDI2 | Intel i7, 32 G RAM, Stockage 1To | ![image](boutique/img/pc2.png)
| Asus | 699.99 | ORDI3 | Intel i5, 8 G RAM, Stockage 2To | ![image](boutique/img/pc3.png)
| Acer | 949.99 | ORDI4 | Intel i7, 16 G RAM, Stockage 2To, RTX 4060 | ![image](boutique/img/pc4.png)

<a id="P3"></a>

# 💡Utiles

__Base de données :__ [boutique.sql](/boutique/sql/boutique.sql) <br>

__Commande :__ 

- Page ventes.php : http://localhost/boutique/ventes.php

- Page panier.php : http://localhost/boutique/panier.php

- Page conneixon.php : http://localhost/boutique/connexion.php

- Page inscription.php :  http://localhost/boutique/inscription.php

<br>

___

<br>

- &copy; Luc.Tournie
- &reg; Carnus
- Date : 23/01/2025