# CodFlix project

## Setup

### Run
1. You have to use a local server such as Wamp or Mamp
1. Import the database `codflix.sql`
1. Pull the repo in the `www/` directory of your local server
1. Follow the address of your repo. For example, if your repo is in ``www/codflix/``, the URL should be http://localhost/codflix or http://127.0.0.1/codflix

Nothing else is required. You can now start your development

## Informations

Le projet Cod'flix est crée dans le cadre de l'épreuve certifiante de l'école Coding Factory en 2020. 

Le code initial ainsi que sa structure ont été respectés. Aucun framework additionnel n'a été ajouté (sauf l'API Youtube Embed, voir ci dessous).

Concernant les fonctionnalités ajoutés, elles respectent les demandes initiées dans le cahier des charges. Les bonus comme l'intégration de TMDB et le support des favoris ont été ajoutés mais pas les médias en lien avec l'utilisateur.


### Youtube embed API

Probablement le seul framework (si on peux l'appeler ainsi) que j'ai ajouté. Elle est d'abord issue de l'équipe de développeur Google, elle permet notamment d'avoir le temps courant de l'utilisateur et elle permet de savoir si le stream est fini.

Au niveau de la maintenabilité, l'API est présente depuis ~2010. Elle n'a pas beaucoup de fonctionnalité mais la documentation explique très bien et les problèmes que j'ai rencontrés personnellement ont été vite résolu grâce à la communauté (Stackoverflow, etc).

Date du début: 23/06/2020

Date de fin: 26/06/2020 à 14h