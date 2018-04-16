####DeathStar connect


* Code style employed PSR2
* install required packages using composer
```php composer.phar install```


####Task one 


* autoload the classes using composer
* Specify endpoints and base url in the config file 
* specify logic in Lib/API Connect
* emmploy use of name spacing
* Message bundle returns the text error messages 

* create mock server using node js for testing 
* execute using json mock server to replicate the respose in task one
         ```npm install```
         execute ```node_modules/json-server/bin/index.js  --watch db.json ``` to start response server
enable debug mode to see more details - see \App\Config\Config::$debug

####Task two

A static Translate Droid class is introduced to the convert the binary code to Text
- i have chosen a static class simply because multiple instances are not required 

a mock response has been added to the test suit to replicate the json response

Make sure you are in the root folder 
Execute ```php composer.phar install``` to install php unit test via composer.  

###### To execute php unit test 
* cd Tasks
* Execute PHPUnit 
 ```php ../vendor/phpunit/phpunit/phpunit --no-configuration TranslateDroidSpeakTest /TranslateDroidSpeakTest.php
 ``` 

