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
5.- Puedes hacer busquedas con fecha y extraer los links mas recientes<br>
6.- Futura actualizacion el uso de proxy

### Funciones y clases que utilizia

( 1 ) [pcntl_fork](https://www.php.net/manual/en/ref.pcntl.php) `Abre Procesos y trabajas con ellos`<br>
( 2 ) [shmop](https://www.php.net/manual/es/book.shmop.php) `Abre un espacio de memoria y almacena informacion { memoria compartida }`<br>
( 3 ) [facilcurl](https://github.com/CR0NYM3X/Facil-Curls-PHP)  `Facilita el uso de Curls`<br>
( 4 ) [class_color](https://github.com/CR0NYM3X/Color-Cli-PHP)  `Agrega color al texto` <br>
( 5 ) [parcli](https://github.com/CR0NYM3X/Argv-Cli-PHP)  `Trabaja con los parametros que ingresas`<br>


# Tambien class_bing_search.php es otra opcion
### Con eliminacion de dominios
```sh
$mm = new bing();

 $mm->eliminarDominio("google.com");
 $mm->eliminarDominio("www.google");
 $mm->eliminarDominio("youtube.com");
 $mm->eliminarDominio("wikipedia.org");
 $mm->eliminarDominio("facebook.org");
 $mm->eliminarDominio("facebook.com");
 $mm->eliminarDominio("fb.com");
 $mm->eliminarDominio("wikipedia.org");
 $mm->eliminarDominio("twitch.org");
 $mm->eliminarDominio("twitter.com");
 $mm->eliminarDominio("twitter.org");
 $mm->eliminarDominio("tiktok.com");
 $mm->eliminarDominio("instagram.com");
 $mm->eliminarDominio("netflix.com");
 $mm->eliminarDominio("wiktionary.org");
 $mm->eliminarDominio("yahoo.com");


$pag= $mm->dork_bing(/* Palabra a buscar */"jose", /* Cantidad de links que queremos*/49); 

if($pag)
{
	print_r($pag[0]);
}
else
{
	echo "No se encontraron links\n";
}
```
![img](https://github.com/CR0NYM3X/Search-Bing-php/blob/main/img/con_filtro_dominio.PNG)

### Sin eliminacion de dominios
```sh
$mm = new bing();

$pag= $mm->dork_bing(/* Palabra a buscar */  "jose", /* Cantidad de links que queremos*/  30);  

if($pag)
{
	print_r($pag[0]);
}
else
{
	echo "No se encontraron links\n";
}
```
![img](https://github.com/CR0NYM3X/Search-Bing-php/blob/main/img/No_filtro_dominio.PNG)


### Ventajas
( 1 ) Es mas preciso con las busqueda ya que realiza una consulta y elimina los dominios no requeridos,
	despues elimina links repetidos, despues obtiene la cantidad de link y se detiene la busqueda de links hasta que la cantidad de link que especificamos sea igual o mayor o que se hayan acabado los links<br>
( 2 ) Elimina link repetidos<br>
( 3 ) Elimina dominios comunes que no quieres que parescan<br>
( 4 ) Puedes usar proxy<br>
( 5 ) Ee puedes especificar la fecha de lanzamiento del los link que queremos <br>
( 6 ) Tambien se pueden usar expresiones regulares para cada link<br>



### Desventajas
( 1 ) Es mas lento<br>
( 2 ) Es una clase y tienes que estar modificando el codigo<br>
( 3 ) No usa fork<br>



### Funciones y clases que utilizia
( 3 ) [facilcurl](https://github.com/CR0NYM3X/Facil-Curls-PHP)  `Facilita el uso de Curls`<br>





## Contribuir
Encontraste un error? por favor de publicarlo en [issue tracker](https://github.com/CR0NYM3X/Search-Bing-php/issues).

## Posibles Problemas
1 - Que no encuentre la direccion de memoria compartida que se le especifica y detenga el programa
