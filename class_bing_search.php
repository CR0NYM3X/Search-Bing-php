<?php

#tiempo de ejecucions
#set_time_limit(0);


require_once("class/class_curl/facilcurl.php");



class bing extends facilcurl
{
	public $count=0;
	private $codigo;
	private $paginasComunes;




	// Se agrega un proxy
	function proxyBing($proxy)
	{
		$this->proxy($proxy); // metodo de la clase faculcurl
	}



	// Elimina dominios que no queremos que aparezcan
	function eliminarDominio($dominio)
	{
		$this->paginasComunes .= "|".preg_replace("[\.]", "\.", $dominio);
	}





	function dork_bing($url,$cantidad=49,$exprecion=null,$fecha="")
	{
		$pagina=0;
		$link=array();
		$link2=array();
		




		// Se especifica la fecha de lanzamiento
		switch ($fecha) 
		{
			case 0:	#NO TIENEFECHA 
				$fecha="";
				break;
			case 1: #FECHA DE 24 HORAS
				$fecha="&filters=ex1:\"ez1\""; 
				break;
			case 2: #FECHA DE ULTIMAS SEMANADAS
				$fecha="&filters=ex1:\"ez2\"";
				break;
			case 3: # FECHA DE ULTIMOS MESES
				$fecha="&filters=ex1:\"ez3\"";
				break;
			default:
				die("EL NUMERO DE FECHA QUE COLOCASTE NO ES CORRECTA NUMEROS PARA USAR:<br>
					0 = SE EXTRAERAN TODOS LINK ENCONTRADOS SIN FLITRO DE FECHA <br>
					1 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE 24 HORAS <br>
					2 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE SEMANADAS  <br>
					3 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE MESES   <br>");
				
		}
	




		
		while (true) 
		{


			$this->curl("https://www.bing.com/search?q=".preg_replace("[\s+]", "+", $url)."&count=50&first=$pagina".$fecha,null,0,null,1);
			


			if(($this->codigo= $this->exe_curl()))
			{


				$link2=$this->url_bing();
				

				if((array_diff($link2, $link))==true) // compara los array y si son iguales se detiene porque se acabaron las paginas
				{

					$link=array_merge($link,$link2);
					#$link= preg_grep("#.r.bat.bing.com#", array_merge($link,$link2),PREG_GREP_INVERT);# esta linea quitaba publicidad ya no sirve esta funcion .r.bat.bing.com


					$link = array_unique($link,SORT_STRING); #QUITANDO LINK REPETIDOS  "PROBLEMA CUANDO EL ARRAY TIENE MAS DE 600 ELEMENTOS"


					if(count($link)>=$cantidad)
					{
				
						break;
					}
					else
					{
							//print_r($link);
							$pagina=$pagina+50;
					}
				}
				else
				{
					break;
				}

			}
			else
			{

				
				break;
			}

		}


		if($exprecion)
		{  

			if(($link2=preg_grep("#$exprecion#i", $link)))  #PREG_GREP_INVERT
			{
				
				return array(0 => $link2,  #son los link que cumplen con la exprecion  
							 1 => count($link2), #cantidad de link encontrados que cumplen con la exprecion
							 2 => preg_grep("#$exprecion#i",$link,PREG_GREP_INVERT), #link que no cumplen con la exprecion
							 3 => count($link), #total de link encontradas
							 4 => (count($link)-count($link2))); #cantidad de link no tomadas en cuanta
			}
			else
			{

				//return array(0 => array("NO SE ENCONTRARON LINK CON LA EXPRECION =  $exprecion"),1=> 0, 2=> 0, 3=>0 ,4=> 0);

				return array(0 => ["NO SE ENCONTRARON LINK CON LA EXPRECION"],
							 1 => 0,
							 2 => $link, #link que no cumplen con la exprecion
							 3 => 0,
							 4 => 0);
			}
		}
		else
		{


			//$link=array_unique($link,SORT_STRING); //eliminamos los repetidos desde aqui
			return array(0 => array_values($link),
						 1 => count($link),
						 2=> 0,
						 3=> 0,
						 4=> 0,
						 5=> 0);
		}

	}




	# este metodo extrae los links por medio de unas expresiones que se le aplica al html ya que hay veces que el codigo varia 
	function url_bing()
	{

		preg_match_all('#<h2><a href="(.*?)"#', $this->codigo, $findlink); // Busqueda de link por default

		if(empty($findlink[1][0]))
		{

			preg_match_all('#<h2><a target="_blank" href="(.*?)" h="ID=#', $this->codigo, $findlink); // al cambiar de ip ciudad cambia el html	
			if(empty($findlink[1][0]))
			{


				preg_match_all('#<h2><a target="_blank" target="_blank" href="(.*?)" h="ID=#', $this->codigo, $findlink);				
				if(empty($findlink[1][0]))
				{
					return $findlink[1];
					//die("NO SE ENCONTRARON URL CON ESTAS EXPRESIONES");
				}
				else

				{
					if(!empty($this->paginasComunes)) // elimina los dominios que no queremos
						return preg_grep("#".substr($this->paginasComunes,1)."#i",$findlink[1],PREG_GREP_INVERT);
					

					return $findlink[1];
				}


			}
			else
			{
				if(!empty($this->paginasComunes))
					return preg_grep("#".substr($this->paginasComunes,1)."#i",$findlink[1],PREG_GREP_INVERT);
				
				return $findlink[1];
			}


		}
		else
		{

			if(!empty($this->paginasComunes))
				return preg_grep("#".substr($this->paginasComunes,1)."#i",$findlink[1],PREG_GREP_INVERT);

			return $findlink[1];
			//print_r($findlink[1][0]);
		}


		
	}


	// Borrando variables
	function __destruct()
	{
		unset($this->codigo);
	}



	
}





//$mm->proxyBing("127.0.0.1:8080");
//$pag= $mm->dork_bing("jose",49,"mx");  





/*

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
*/

//$pag= $mm->dork_bing(/* Palabra a buscar */  "jose", /* Cantidad de links que queremos*/  100	, /* Espresion*/ "\.edu");  

/*
if($pag)
{
	print_r($pag[0]);
}
else
{
	echo "No se encontraron links\n";
}

*/



?>