# Metrics
Analyser la qualité de conception et la popularité des librairies web en php.

### Prérequis

1. [Docker](https://docs.docker.com/engine/installation/)
2. [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1. Construisez les conteneurs

    ***Tip**: vous pouvez omettre l'option `--no-cache` s'il s'agit de la première exécution.*
    ***Tip**: windows uniquement - ouvrez le terminal en tant qu'administrateur.*
    
    ```bash
    docker-compose build --no-cache
    ```
   
2. Lancez l'environnement

    ***Tip**: si vous ne voulez pas démonifier les conteneurs, vous pouvez omettre l'option `-d`.*
    
    ```bash
    docker-compose up -d
    ```

3. Configurer l'application

    ```bash
    docker-compose exec metrics ./script/setup
    ```

Et vous avez terminé!

### Utilisation

1. Lancez l'application

    ```bash
    docker-compose exec metrics ./metrics
    ```
   
 2. Visualisez les résultats
 
    Si votre navigateur ne s'ouvre pas automatiquement, veuillez ouvrir `analysis/index.html` avec votre navigateur préféré.
