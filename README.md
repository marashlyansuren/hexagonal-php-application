# hexagonal-php-application


## How do I get set up? ###

### Local 
#### Up docker compose services:  
_From root directory, run following command_  
 ```
 make up
 ```
#### PHP application Dependencies:  
_Install dependencies_  
 ```
 make composer-install
 ```
#### **Database configuration:**
_Next just run migrate to apply all changes to Database_  
 ```
 make migrate
 ```  
If you made any change domain schema, run diff and again run migrate  
 ```
 make diff
 ```  
### Generate the SSL keys: ###    
```
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
After this make sure that you have updated `JWT_PASSPHRASE` from `.env` (`.env.local` if exists)  value by the new password that you have used for secret generation
#### Enjoy!

## Setup Xdebug in phpstorm

[Link to the document](https://docs.google.com/document/d/1_KdMp3WH65VV6CEqJdM0q8543WzjbrWOccHEAjNemsM/edit?usp=sharing)
