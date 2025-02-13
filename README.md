# Local set up

### On your local machine:

1. Clone the project form repository
```
git clone git@github.com:Abuziarova/KK-Course-Bundle-System.gitt
```

2. Add permission for a group (in main directory):
```
sudo chgrp -R 33 ./
```
3. In the local main project folder create .env file:
```
cp .env.dist .env
```

4. Run the docker containers:
``` 
 docker compose up -d
```
(Compose v2)


### Inside the 'shopware' container

5. Run in the container
```
composer install 
```

6. Install the system
```
 bin/console system:install
```

7. Instal plugin
```
bin/console plugin:install --activate AlgotequeRecommendationSystem
```



# API endpoint using

send POST request to url
```
http://localhost/get-bundle-quotes
```

request body structure
{
"topics": {
"reading": 20,
"math": 50,
"science": 30,
"history": 15,
"art": 10
}
}
