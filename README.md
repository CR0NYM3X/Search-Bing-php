# Search Bing
Ejemplo  de ejecucion :    `  php searchbing.php -w gobierno -mnt 200  -d * -outf info.txt -exp "\.com|\.mx" -cl -fk`<br><br>
       ********** PARAMETRO OPCIONAL, LO PUEDES PONER O NO `[ -d ]`<br>
        * = SE EXTRAERAN TODOS LINK ENCONTRADOS SIN FLITRO DE FECHA <br>
				1 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE 24 HORAS <br>
				2 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE SEMANADAS  <br>
				3 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE MESES<br>

![logo](img/banner1.PNG)
![test](img/procesos.png)

## Ventajas
1.- Utiliza Fork, lo cual divide el trabajo y realiza consultas rapidas<br>
2.- Elimina Links repetidos<br>
3.- Puedes filtrar los link con expresiones regulares<br>
4.- Almacena los resultados en TXT<br>
5.- Puedes hacer busquedas con fecha y extraer los links mas recientes
6.- Futura actualizacion el uso de proxy

### Funciones y clases que utilizia

( 1 ) [pcntl_fork](https://www.php.net/manual/en/ref.pcntl.php) `Abre Procesos y trabajas con ellos`<br>
( 2 ) [shmop](https://www.php.net/manual/es/book.shmop.php) `Abre un espacio de memoria y almacena informacion { memoria compartida }`<br>
( 3 ) [facilcurl](https://github.com/CR0NYM3X/Facil-Curls-PHP)  `Facilita el uso de Curls`<br>
( 4 ) [class_color](https://github.com/CR0NYM3X/Color-Cli-PHP)  `Agrega color al texto` <br>
( 5 ) [parcli](https://github.com/CR0NYM3X/Argv-Cli-PHP)  `Trabaja con los parametros que ingresas`<br>




## Contribuir
Encontraste un error? por favor de publicarlo en [issue tracker](https://github.com/CR0NYM3X/Search-Bing-php/issues).

## Posibles Problemas
1 - Que no encuentre la direccion de memoria compartida que se le especifica y detenga el programa
