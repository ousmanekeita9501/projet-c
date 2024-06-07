Kané Mohamed Lamine

1. Initialisation et Configuration 

a. Cloner le dépôt mentionné

git clone https://github.com/kane575/versionning.git
Clone le dépôt GitHub spécifié sur la machine locale.

b. Configurer votre identité Git avec votre nom et votre email


git config --global user.name "kane575"
git config --global user.email "mohamedkane580@gmail.com"

Configure le nom d'utilisateur et l'email pour les commits Git.

2. Création de branches et développement 

a. Créer et basculer sur une nouvelle branche nommée `feature`


git checkout -b feature

Crée une nouvelle branche `feature` et bascule dessus.

b. Ajouter un fichier `README.md` avec une description du projet

echo "# Projet Versionning" > README.md
echo "Ceci est un projet de test pour apprendre le versionning avec Git." >> README.md
Crée un fichier `README.md` avec une description du projet.

c. Commiter vos changements


git add README.md
git commit -m "Ajout du fichier README.md avec une description du projet"

Ajoute le fichier `README.md` à l'index (staging area) et crée un commit avec un message descriptif.

3. Gestion des conflits 

a. Retourner sur la branche `main` et envoyer les dernières modifications vers le dépôt distant

git checkout main
git merge feature
git push origin main

Bascule sur la branche `main`, fusionne les modifications de `feature` dans `main`, et envoie les modifications au dépôt distant.


c. Basculer sur la branche `feature` en veillant à ne pas perdre le contenu du fichier `index.html`


git checkout feature
Bascule sur la branche `feature`.

d. Ajouter ce commentaire dans le fichier `README.md` : "Bon retour sur la branche feature"


echo "\n## Bon retour sur la branche feature" >> README.md

Ajoute un commentaire dans le fichier `README.md`.

e. Envoyer les dernières modifications sur le dépôt


git add README.md
git commit -m "Ajout du commentaire 'Bon retour sur la branche feature' dans README.md"
git push origin feature

Ajoute le fichier `README.md` à l'index (staging area), crée un commit avec un message descriptif et pousse les modifications à la branche `feature` du dépôt distant.

f. Retourner à la branche principale et compléter le fichier `index.html` comme suit :

git checkout main


git add index.html
git commit -m "Compléter le fichier index.html avec le contenu complet"
git push origin main

Complète le fichier `index.html` avec le contenu spécifié, ajoute les changements à l'index (staging area), crée un commit et pousse les modifications à la branche `main` du dépôt distant.

g. Fusionner la branche `feature` dans `main` et résoudre tout conflit éventuel

git merge feature


Résoudre les conflits éventuels en éditant les fichiers conflictuels
git add .
git commit -m "Résoudre les conflits entre main et feature"
git push origin main

Fusionne la branche `feature` dans `main`, résout les conflits éventuels, ajoute les changements à l'index, crée un commit et pousse les modifications à la branche `main` du dépôt distant.

Documenter les étapes de résolution de conflit dans le rapport


echo "\n## Résolution des conflits" >> report.md
echo "Lors de la fusion de la branche feature dans main, les étapes suivantes ont été suivies :" >> report.md
echo "1. Utilisation de 'git merge feature' pour fusionner la branche feature dans main." >> report.md
echo "2. Résolution des conflits en éditant les fichiers conflictuels." >> report.md
echo "3. Ajout et commit des résolutions de conflits." >> report.md
echo "4. Pousser les modifications finales vers le dépôt distant." >> report.md

git add report.md
git commit -m "Documentation des étapes de résolution des conflits dans report.md"
git push origin main

le repository
https://github.com/Kane575/report.git

