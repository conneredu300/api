A simple app for s2it

##REQUERIMENTS
    php7.1, Mysql, Curl, Apache

##HOWTO (linux)
    apt-get update && sudo apt-get upgrade;
    sudo apt-get install apache2 -y;
    sudo apt-add-repository ppa:ondrej/php;
    sudo apt-get update;
    sudo apt-get install php7.1;
    sudo apt-get install mysql-server php7.1-mysql; (username must be "root" and password must be "admin")
    sudo service apache2 restart;
    sudo service mysql restart;

##FIRST STEPS
    #1. Create a database called "teste";
    #2. Clone the app
    #3. Create an .env file in the root of app, then insert line "DATABASE_URL=mysql://root:admin@127.0.0.1:3306/teste"
    #4. Execute composer install
    #5. Run "php bin/console doctrine:migration:migrate"
    #6. Start the server running "php -S 127.0.0.1:8000 -t public/" (in the app folder)

##APP
    Open http://127.0.0.1:8000 in a browse then upload the people.xml and shiporders.xml files respectively

##API
    Create an user for api
    INSERT INTO user VALUES(null,"name1",'{"role":"ROLE_ADMIN"}',"1234kasokd","admintesttoken");

    In order to fetch people
    curl -H "X-AUTH-TOKEN:admintesttoken" http://127.0.0.1:8000/api/people/{peopleId}

    In order to fetch item
    curl -H "X-AUTH-TOKEN:admintesttoken" http://127.0.0.1:8000/api/item/{itemId}

    In order to fetch shiporders
    curl -H "X-AUTH-TOKEN:admintesttoken" http://127.0.0.1:8000/api/shiporder/{shiporderId}