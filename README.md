# Proyecto de Configuración  

Este archivo describe la configuración necesaria para el proyecto.  

## Variables de Entorno  

Asegúrate de configurar las siguientes variables de entorno en tu archivo `.env`:  

### Dominio  

- `DOMAIN`: Indica el dominio o dirección IP del servidor. Ejemplo:  
  ```env  
  DOMAIN=localhost

- `MODE`: Indica el modo en el que estara el proyecto, DEVELOPMENT es para ver todo los errores y sigerencia que tira php. Ejemplo:  
  ```env  
  MODE=DEVELOPMENT

- `USER`: usuario para la conneccion a la base de datos. Ejemplo:  
  ```env  
  USER=usuario

- `PASS`: COntraseña del usuario. Ejemplo:  
  ```env  
  PASS=password

- `DSN`: Cadena de conección a la base de datos Ejemplo:  
  ```env  
  DSN="mysql:host=localhost;dbname=residencial;charset=utf8mb4"