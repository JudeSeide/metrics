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
    
### Bibliography
    Frankl, D. (2014). Machine Learning In JavaScript.
    Frakes, W. B., & Kang, K. (2005). Software reuse research: Status and future. IEEE transactions on Software Engineering, 31(7), 529-536.
    Laguna, M. A., & Oscar, L. (2003, September). Introducing systematic reuse in mainstream software process. In null (p. 351). IEEE.
    Fowler, M. (2018). Refactoring: improving the design of existing code. Addison-Wesley Professional.
    Collins, K. (2018). How one programmer broke the internet by deleting a tiny piece of code. Quartz. https://qz.com/646467/how-one-programmer-broke-the-internet-by-deleting-a-tiny-piece-of-code/ Zugegriffen, 30.
    Beyer, C. (2018). The Node.js Ecosystem Is Chaotic and Insecure. Medium.  https://medium.com/commitlog/the-internet-is-at-the-mercy-of-a-handful-of-people-73fac4bc5068/
    Sajnani, H., Saini, V., Ossher, J., & Lopes, C. V. (2014, September). Is popularity a measure of quality? an analysis of maven components. In 2014 IEEE international conference on software maintenance and evolution (pp. 231-240). IEEE.
    Corral, L., & Fronza, I. (2015, May). Better code for better apps: a study on source code quality and market success of Android applications. In 2015 2nd ACM International Conference on Mobile Software Engineering and Systems (pp. 22-32). IEEE.
    Weber, S., & Luo, J. (2014, December). What makes an open source code popular on git hub?. In 2014 IEEE International Conference on Data Mining Workshop (pp. 851-855). IEEE.
    Borges, H., Hora, A., & Valente, M. T. (2016, October). Understanding the factors that impact the popularity of GitHub repositories. In 2016 IEEE International Conference on Software Maintenance and Evolution (ICSME) (pp. 334-344). IEEE.
    Alexandrov, S. “Reliability of complex services. unpublished. http://www. cs. rutgers. edu/~ rmartin/teaching/spring06/cs553/papers.
    Yu, S., & Zhou, S. (2010, April). A survey on metric of software complexity. In 2010 2nd IEEE International Conference on Information Management and Engineering (pp. 352-356). IEEE.
    Lépine, J. F. (2015). How to understand the PhpMetrics’ metrics. phpmetrics. Org.
    Russell, C. (2016). Dependency Management. In PHP Development Tool Essentials (pp. 67-82). Apress, Berkeley, CA.
