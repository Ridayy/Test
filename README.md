## **Installation:**
    git clone https://github.com/ammarbrohi/socialfreak.git
    cd socialfreak
    composer install

## **Running:**
    php artisan serve
This will start on port 8000

## **SSH Tunnel - to expose localhost to internet:**

OPEN new Git Bash Window and run :

	ssh -R socialfreak:80:localhost:8000 54.158.228.131 -p 2222
#### navigate to [https://socialfreak.cartcake.tech](https://socialfreak.cartcake.tech "https://socialfreak.cartcake.tech")

## Routes

[https://socialfreak.cartcake.tech/fb-login](https://socialfreak.cartcake.tech "https://socialfreak.cartcake.tech/fb-login")

[https://socialfreak.cartcake.tech/fbpost](https://socialfreak.cartcake.tech/fbpost "https://socialfreak.cartcake.tech/fbpost")

[https://socialfreak.cartcake.tech/fbcallback](https://socialfreak.cartcake.tech/fbcallback "https://socialfreak.cartcake.tech/fbcallback")


## Files to play with
```
├── app
│   ├── Http
│   │      ├── Controllers
│   │      │.      ├── FacebookController.php
└── .env
```
