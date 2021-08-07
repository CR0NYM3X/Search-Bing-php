<?php

#tiempo de ejecucions
#set_time_limit(0);


require_once("class/class_curl/facilcurl.php");



class bing extends facilcurl
{
	public $count1=0;
	private $codigo;

	function dork_bing($url,$cantidad=49,$exprecion=null,$fecha="")
	{
		$pagina=0;
		$link=array();
		$link2=array();
		

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
			$l= "https://www.bing.com/search?q=".preg_replace("[\s+]", "+", $url)."&count=50&first=$pagina".$fecha;


			$this->curl($l);

			


			if(($this->codigo= $this->exe_curl()))
			{

				$link2=$this->url_bing();
				

/*
				print_r($link2);
				$archivo = fopen("paginalllllllllllllllll.html","w+b");
				fwrite($archivo,$this->codigo );
				fclose($archivo);
				die("se acabo".$l);
				*/

				if((array_diff($link2, $link))==true)
				{

					$link=array_merge($link,$link2);
					#$link= preg_grep("#.r.bat.bing.com#", array_merge($link,$link2),PREG_GREP_INVERT);# quitaba publicidad ya no sirve esta funcion .r.bat.bing.com

					
					//echo "1----".count($link)."\n";
					$link = array_unique($link,SORT_STRING); #QUITANDO LINK REPETIDOS  "PROBLEMA CUANDO EL ARRAY TIENE MAS DE 600 ELEMENTOS"
					//echo "-------".count($link)."\n";

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
		{  #por si quieres que el link cumpla con una expresion

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

				return array(0 => array("NO SE ENCONTRARON LINK CON LA EXPRECION"),1=> 0, 2=> 0, 3=>0 ,4=> 0);
			}
		}
		else
		{
			$link=array_unique($link,SORT_STRING); //eliminamos los repetidos desde aqui
			return array(0 => $link, 1 => count($link),2=> 0, 3=> 0, 4=>0 ,5=> 0);
		}

	}





	function url_bing()
	{


		$this->count1=$this->count1+1;
		


		preg_match_all('#<h2><a href="(.*?)"#', $this->codigo, $findlink); // Busqueda de link por default

		
		if(empty($findlink[1][0])){

			//echo "ESTA VACIO EL 1\n";
			preg_match_all('#<h2><a target="_blank" href="(.*?)" h="ID=#', $this->codigo, $findlink); // al cambiar de ip ciudad cambia el html	
			

			if(empty($findlink[1][0])){


				//echo "ESTA VACIO EL 2\n";
				preg_match_all('#<h2><a target="_blank" target="_blank" href="(.*?)" h="ID=#', $this->codigo, $findlink);				
				
				if(empty($findlink[1][0])){

					return $findlink[1];
					//die("NO SE ENCONTRARON URL CON ESTAS EXPRESIONES");
				}else{return $findlink[1];}



			}else{return $findlink[1];}


		}else{

			return $findlink[1];
			print_r($findlink[1][0]);
		}


		
	}




	function __destruct()
	{
		unset($this->codigo);
		unset($pagina);
		unset($resultado);
		unset($findlink);
		unset($link);
		unset($link2);

	}



	
}


/*

$mm = new bing();
$pag= $mm->dork_bing("jose",500);  //  dork_bing($url,$cantidad=49,$exprecion=null,$fecha="")

if($pag)
{
	print_r($pag[1]);
}
else
{
	echo "no se pudo\n";
}

*/

?>