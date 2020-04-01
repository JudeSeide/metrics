# Metrics
Analyse the design quality and the popularity of web libraries in php.

### Requirements

1. [Docker](https://docs.docker.com/engine/installation/)
2. [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1. Build the containers

    ***Tip**: you may omit the `--no-cache` option if it's the first run.*
    ***Tip**: windows only - open the terminal as administrator.*
    
    ```bash
    docker-compose build --no-cache
    ```
   
2. Bring up the environment

    ***Tip**: if you don't want to daemonize the containers, you may omit the `-d` option.*
    
    ```bash
    docker-compose up -d
    ```

3. Setup the application

    ```bash
    docker-compose exec metrics ./script/setup
    ```

And you're done!

### Usage

1. Launch the application

    ```bash
    docker-compose exec metrics ./metrics
    ```
   
 2. Visualize results
 
    If your browser do not open automatically, please open `analysis/index.html` with your favorite browser.
