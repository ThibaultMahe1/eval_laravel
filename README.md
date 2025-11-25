Application Laravel pour la gestion d'un championnat (Équipes, Joueurs, Rencontres).

1. **Cloner le dépôt**

    ```bash
    git clone <votre-url-de-repository>
    cd eval_laravel
    ```

2. **Installer les dépendances PHP**

    ```bash
    composer install
    ```

3. **Installer les dépendances JavaScript**

    ```bash
    npm install
    npm run build
    ```

4. **Configuration de l'environnement**
   Dupliquez le fichier d'exemple `.env.example` pour créer votre fichier de configuration `.env` :

    ```bash
    cp .env.example .env
    ```

    Ouvrez le fichier `.env` et configurez vos informations de base de données (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5. **Générer la clé d'application**

    ```bash
    php artisan key:generate
    ```

6. **Base de données et Seeders**
   Lancez les migrations et peuplez la base de données avec les données de test :

    ```bash
    php artisan migrate --seed
    ```

## Comptes de démonstration

**Compte Admin :**

-   Identifiant : `admin@example.com`
-   Mot de passe : `password`

**Compte Arbitre :**

-   Identifiant : `arbitre@example.com`
-   Mot de passe : `password`

## Informations complémentaires
