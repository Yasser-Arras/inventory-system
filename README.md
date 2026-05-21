#  Système de Gestion de Stock

Application web de gestion de stock réalisée avec Laravel et Tailwind CSS.
Ce projet permet de gérer les produits, les ventes, les fournisseurs, les utilisateurs et les mouvements de stock dans une interface moderne et simple.

---

# Fonctionnalités

* Gestion des produits
* Gestion des catégories
* Gestion des fournisseurs
* Gestion des utilisateurs
* Gestion des ventes
* Gestion des mouvements de stock
* Tableau de bord avec statistiques
* Système de rôles (Admin / Caissier / Utilisateur)
* Interface responsive moderne

---

#  Technologies utilisées

* Laravel
* PHP
* MySQL
* Tailwind CSS
* Vite
* Alpine.js
* Javascript
---

#  Installation du projet

## 1. Cloner le projet


## 2. Entrer dans le dossier du projet

```bash id="r1v1c5"
cd votre-repository
```

---

## 3. Installer les dépendances PHP

```bash id="z4mv2w"
composer install
```

---

## 4. Installer les dépendances Node.js

```bash id="4kjf0q"
npm install
```

---

## 5. Créer le fichier `.env`

```bash id="eyg2d5"
cp .env.example .env
```

---

## 6. Générer la clé Laravel

```bash id="lb5qst"
php artisan key:generate
```

---

## 7. Configurer la base de données

Modifier les informations dans le fichier `.env` :

```env id="p0r4zu"
DB_DATABASE=nom_de_la_base
DB_USERNAME=root
DB_PASSWORD=
```

---

## 8. Lancer les migration

```bash id="avw1na"
php artisan migrate
```

---

## 9. Lancer le seeder

```bash id="avw1na"
php artisan db:seed
```

---
#  Lancer le projet

## Démarrer le serveur Laravel

```bash id="gg2jpi"
php artisan serve
```

## Démarrer Vite

```bash id="3qjlwm"
npm run dev
```

---

#  Build production

```bash id="4yffur"
npm run build
```

---

# 👤 Comptes / rôles

Le système contient 3 rôles :

* Admin
* Caissier
* Utilisateur
* 
#  Comptes de démonstration

| Rôle        | Nom      | Email                                         | Mot de passe |
| ----------- | -------- | --------------------------------------------- | ------------ |
| Admin       | Admin1   | [admin@test.com](mailto:admin@test.com)       | password     |
| Caissier    | Cashier1 | [cashier@test.com](mailto:cashier@test.com)   | password     |
| Utilisateur | John Doe | [johndoe@gmail.com](mailto:johndoe@gmail.com) | 00000000     |

---


Projet réalisé par Yasser Arras.
