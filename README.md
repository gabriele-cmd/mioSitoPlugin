-- GUIDA ALL'USO --
1. Aprire i container Docker di Apache e di MYSQL

    1.1 Per avviare il container Apache basta eseguire dal proprio cmd il seguente comando: "docker run -d -p 8090:80 --name my-apache-php-app --rm  -v /home/informatica/mio-sito:/var/www/html zener79/php:7.4-apache" modificando ovviamente il path "/home/informatica/mio-sito" col path in cui si trova il proprio progetto.

    1.2 Per avviare invece il container MYSQL dove risiederà il nostri Database occorre eseguire il seguente comando:
    "docker run --name my-mysql-server --rm -v /home/informatica/mysqldata:/var/lib/mysql -v /home/informatica/dump:/dump -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest" cambiando ovviamente i rispettivi percorsi file e avendo cura di creare manualmente la cartella "dump" nel percorso desiderato così da averne libero accesso

2. Scaricare il file create_employee.sql contenente il codice per la creazione del database e inserirlo nella cartella dump precedentemente creata
    
    2.1 Caricare il file appena scaricato sul container MYSQL attraverso i seguenti comandi:
    "docker exec -it my-mysql-server bash" per aprire la bash e "mysql -u root -p < /dump/create_employee.sql; exit;" per caricarlo

3. Collegarsi tramite Browser alle URL disponibili:
    
    3.1 localhost:8090/tabella.html per visualizzare il FRONTEND
    
    3.2 localhost:8090/index.php per visualizzare il BACKEND in formato JSON

4. COLLEGAMENTO EFFETTUATO!



-- FUNZIONI DISPONIBILI --  
Nel progetto sono state implementate le diverse funzioni testabili direttamente da browser:

- AGGIUNTA
- MODIFICA
- ELIMINAZIONE
- PAGINAZIONE dinamica che include:
    - la pagina CORRENTE (rappresentata dal numero variabile)
    - la pagina PRECEDENTE (rappresentata da <<)
    - la pagina SUCCESSIVA (rappresentata da >>)
    - la PRIMA pagina (rappresentata da First)
    - l'ULTIMA pagina (rappresentata da Last)

- RICERCA di un elemento effettuabile da:
    - FRONTEND utilizzando l'apposita casella di ricerca oppure tramite query URL (inserendo ?id=xxxxx prima del fragment)
    - BACKEND (ovvero index.php) esclusivamente tramite query URL

    - N.B. La funzione di RICERCA del FRONTEND presenta ancora diversi problemi ed è tutt'ora INCOMPLETA, fai riferimento alle NOTE FINALI per ulteriori dettagli.



-- NOTE FINALI E CONSIDERAZIONI --

- Tutti i file del progetto sono stati inseriti in un'unica cartella per ragioni di comodità

- Nella PAGINAZIONE i pulsanti per raggiungere le pagine PRECEDENTI e SUCCESSIVE sono DISABILITATI nel caso in cui ci troviamo rispettivamente nella PRIMA e nell'ULTIMA pagina

- La RICERCA di un elemento attraverso FRONTEND è ancora incompleta e presenta i seguenti problemi di difficile risoluzione:

    - Attualmente è impossibile cercare un elemento non appartenente alla pagina che viene caricata di default (la prima, con number = 0) poiché non è stato possibile trovare un modo per scorrere le pagine del JSON nella creazione della tabella.

    - Se si effettua una ricerca qualsiasi (che sia da url o da apposita casella, che dia esito negativo o positivo) e poi si prova a cancellare l'ID da cercare dalla casella (o effettuando una ricerca con ?id= in url) e si clicca su cerca (o si ricarica se da url) non verranno caricati tutti i dati e la pagina rimarrà vuota, per ritornare alla paginazione iniziale occorrerà refreshare la pagina (o eliminare la query dall'url). Questo perché non è stato possibile gestire il caso in cui le variabili passate dalla query risultano stringhe vuote (es. "")

- La RICERCA di un elemento attraverso URL nel file index.php (BACKEND) invece è completa e perfettamente funzionante

- Se possibile il progetto verrà riaggiornato in futuro cercando di sistemare questi pochi problemi appena elencati sulla funzione aggiuntiva della RICERCA. :)
