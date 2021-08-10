<?php

#tiempo de ejecucions
set_time_limit(0);

error_reporting(0); // NO MUESTRA ERRORES, SI QUIERES VER QUE PROBLEMA TIENES COMENTA ESTA LINEA

require_once("class/class_curl/facilcurl.php");   // importando clase para usar mas facil las curl
require_once("class/class_parcli/parcli.php");		// ponerle unformacion al script
require_once("class/color_cli/class_color.php");	// darle color al scrpit
require_once("class/memory_share/memsha.php");   // funciones para facilitar la memoria compartida

$txtcl = new Color_texto();





$p= new parcli($txtcl->txtcolor("Ejmplo:",1,"verde","negro").' php '.$argv[0].' -w "site:gov.com" -exp "login.php|acceso.php" -d * -mnt 500');

echo $txtcl->txtcolor("\t##########################################\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##                                      ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##        ###   %  #    #  ######       ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##        #  #     # #  #  #            ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##        ###   #  #  # #  #  ###       ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##        #  #  #  #   ##  #    #       ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##        ###   #  #    #  ######       ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##                                      ##\n",1,"rojo","negro");
echo $txtcl->txtcolor("\t##########################################\n",1,"rojo","negro");


$p->setDescription('Uso: php '.$argv[0].' -w  [ Palabra a buscar ] -exp [ Esprecion Regular ] -d [ fecha ] -mnt [ Cantidad que quieres para buscar ]');
$p->setParam(	'-w',		'--W',		'String',	'Poner palabra a buscar',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-exp',		'--EXP',	'String',	'Aplicar Exprecion regular en cada link',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-d',		'--D',		'Int',	'Buscar por Fecha o se pone * para buscar todas las fechas',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-mnt',		'--MNT',	'Int',	'Cantidad de links que quieres',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-outf',		'--OUTFILE',	'File',	'Guardar link en archivo, por default usa los archivos {Data_bing/Data.txt}',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-inf',		'--INFILE',	'File',	'Archivo para realizar busqueda masiva',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-proxy',		'--PROXY',	'IP:PORT',	'Conectate a un proxy',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-fk',		'--FK',	'Opcion',	'Controla los fork y da orden',/*Required*/ false,/*Item de Array*/	'url');
$p->setParam(	'-cl',		'--CLEAR',	'Opcion',	'Limpia los Archivos y ingresa nuevos links {Data_bing}',/*Required*/ false,/*Item de Array*/	'url');
$p->setArgv($argv);


# php bingfind.php -w "site:gov.com" -exp "login.php|acceso.php" -d * -mnt 500 -cl
# php bingfind.php -inf "/Data_bing/Dorks.txt" -outf "resultados.txt"  -exp "login.php|acceso.php" -d * -mnt 500 -cl 
#   php bingfind.php -w gobierno -mnt 200  -d * -outf info.txt -exp "\.com|\.mx" -cl -fk


echo "\n\n\n";
//print_r($argv);


$cntLinks=15;
$fecha="*";
$rutaDatalink = "Data_bing/Data.txt";
$expLinks;
$proxy;

// VERIFICANDO QUE SE INGRESEN PARAMETROS IMPORTANTES
if( count($argv) == 1){
	die(0);
}
if(array_search("-h",$argv)){
	die(0);
}
if(!($argvW=array_search("-w",$argv))){
	die( $txtcl->txtcolor("\t NO SE INGRESO EL PARAMETRO [ -w ]  \n",1,"rojo","negro"). "\n");
}else{

	$palabra=$argv[($argvW+1)];   // PALABRA QUE QUIERO BUSCAR EN BING
}
if(!($argvMnt = array_search("-mnt",$argv)) ){
	die( $txtcl->txtcolor("\t NO SE INGRESO EL PARAMETRO [ -mnt ]  \n",1,"rojo","negro"). "\n");
}else{

	if ( @is_numeric($argv[($argvMnt+1)]) ) {
		$cntLinks=ceil( ($argv[($argvMnt+1)]/50) );	
	}
	
	echo $txtcl->txtcolor("\t (*) CONSULTAS POR REALZAR :  ".$cntLinks." ",3,"blanco","morado")."\n";
}

if( ($argvEXP = array_search("-exp",$argv)) ){

	if(!empty($rutaDatalink = @$argv[($argvEXP+1)])){
		$expLinks = $argv[($argvEXP+1)];
		echo $txtcl->txtcolor("\t (*) APLICANDO EXPRESION REGULAR : ".$expLinks,3,"blanco","morado")."\n";
	}else{
			die( $txtcl->txtcolor("\t PARAMETRO [ -EXP ] ESTA VASIO  \n",1,"rojo","negro"). "\n");
	}

}




if( ($argvD = array_search("-d",$argv)) ){
	if ( @is_numeric($argv[($argvD+1)]) ) {
		$fecha=$argv[($argvD+1)];
	}
}

if ( ($argvOUTF = array_search("-outf",$argv)) ) {
		
		
		if(!empty($rutaDatalink = @$argv[$argvOUTF+1])){
			echo $txtcl->txtcolor("\t (*) NUEVA RUTA DE LINKS : ".$rutaDatalink,3,"blanco","morado")."\n";
		}
		else{
			die( $txtcl->txtcolor("\t PARAMETRO [ -outf ]  ESTA VASIO  \n",1,"rojo","negro"). "\n");
		}
}

if (  array_search("-cl",$argv) ) {
	
	echo $txtcl->txtcolor("\t (*) SE LIMPIO EL TXT DE LINKS \n",3,"blanco","morado");
	guardadData("","w",$rutaDatalink);


	if( $argvEXP )
	{
		guardadData("","w","Data_bing/Data_not_Filter.txt");
		echo $txtcl->txtcolor("\t (*) SE LIMPIO EL TXT QUE NO APLICARON CON LA EXPRESION",3,"blanco","morado")."\n";
	}


}


if(array_search("-fk",$argv)){
	$orderFork=true;
}else{
	$orderFork=false; // esto hace que se habilite el wait y espera 1 el primer proceso que continue para que se ejecute el segundo asi sisesivamente
}


if( ($argvProxy = array_search("-proxy",$argv)) ){
	$proxy = $argv[($argvProxy+1)];
	echo $txtcl->txtcolor("\t (*) Conectar a Proxy : ".$proxy,3,"blanco","morado")."\n";
}







function guardadData($data="",$permiso="w",$ruta="Data_bing/Data.txt") // permiso a
{

	$file = fopen($ruta, $permiso);
	if(is_array($data))
	{
		foreach ($data as $dataArray) {
			fwrite($file, $dataArray.PHP_EOL);
		}
	}
	else
	{
		fwrite($file, $data.PHP_EOL);
	}
	
	fclose($file);

}






function consultBing($url,$cnt1,$idproces)
{
	global $proxy;
	$txtcl = new Color_texto();
	$mm = new facilcurl();

	if(!empty($proxy))
	{	
		$mm->proxy($proxy);
	}

	

	$mm->curl($url,null,0,null,1);

	// VERIFICA SI SE HIZO LA CONSULTA A LA PAGINA
	if ($pag = $mm->exe_curl()) 
	{




		# IF DONDE EXTRAE LOS LINK CON RESPECTIVOS FILTROS
		preg_match_all('#<h2><a href="(.*?)"#', $pag , $findlink);
		if (empty($findlink[1])) 
		{

				preg_match_all('#<h2><a target="_blank" href="(.*?)" h="ID=#', $pag , $findlink); 
				if( empty($findlink[1]) )
				{


					preg_match_all('#<h2><a target="_blank" target="_blank" href="(.*?)" h="ID=#', $pag , $findlink);
					if( empty($findlink[1]) )
					{
						echo $cnt1."---\t".$url.$txtcl->txtcolor("\t- Esta vacio \n",1,"rojo","negro");

					}
					else
					{
						echo $cnt1." ---\t".$url. $txtcl->txtcolor("\t- EXITOSO ",1,"verde1","negro")." pid : ".$idproces. "\n";
						openSM($findlink[1],$idproces); //haciendo la memoria compartida
					}


				}
				else
				{
					echo $cnt1." ---\t".$url.$txtcl->txtcolor("\t- EXITOSO ",1,"verde1","negro")." pid : ".$idproces. "\n";
					openSM($findlink[1],$idproces);
				}
		}	
		else
		{
			echo $cnt1." ---\t".$url.$txtcl->txtcolor("\t- EXITOSO ",1,"verde1","negro")." pid : ".$idproces. "\n";
			openSM($findlink[1],$idproces);
		}




	}
	else
	{	
		echo "Error al entrar\n";
	}

}














// AQUI ES DONDE SE HACEN LA CANTIDAD DE LINK QUE SE NECESITAN



	switch ($fecha) 
	{
		case "*":	#NO TIENEFECHA 
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
			die("EL NUMERO DE FECHA QUE COLOCASTE NO ES CORRECTA NUMEROS PARA USAR:
				0 = SE EXTRAERAN TODOS LINK ENCONTRADOS SIN FLITRO DE FECHA 
				1 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE 24 HORAS 
				2 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE SEMANADAS  
				3 = SE EXTRAERAN LOS LINK QUE TENGAN UN TIEMPO DE MESES\n");
			
	}


$links=[];
$paginacion=0;

for ($i=1; $i <= $cntLinks ; $i++) { 
	$links[].="https://www.bing.com/search?q=".preg_replace("[\s+]", "+", $palabra)."&count=50&first=".$paginacion.$fecha;
	$paginacion+=50;
}
















//	AQUI SE TRAAJA CON LOS FORK Y SE MANDA EJECUTAR CADA LINK Y SE GUARDA EN LA MEMORIA COPARTIDA

$cnt=0;
foreach ($links as $dataLinks) {
	$cnt++;
  $pid = pcntl_fork();


  if ($pid == -1) {
    exit("Error forking...\n");
  }else if($pid){

  	$pids[$pid] = $pid;
  	
  	if($orderFork)
  	{
  		while(pcntl_waitpid(0, $status) != -1);
  	}
	

  }else{

    consultBing($dataLinks,$cnt,getmypid());
 
    exit();
  }

}



















##  AQUI ES DONDE SE ACCEDE A LAS MEMORIAS COMPARTIDAS Y SE EXTRAE LA INFORMACION

$linksMemoryShare=[];
# donde extrae los links
if (!$orderFork) {
	while(pcntl_waitpid(0, $status) != -1);
}

foreach ($pids as  $idvalue) {
 	$linksMemoryShare = array_merge($linksMemoryShare , getSM($idvalue)); 	
}


$linksMemoryShare= array_unique($linksMemoryShare,SORT_STRING); // elimina link repetidos



if(!empty($expLinks)){

	
	$linksMemoryShareInvert	= preg_grep("#$expLinks#i",$linksMemoryShare,PREG_GREP_INVERT);
	$linksMemoryShare =preg_grep("#$expLinks#i", $linksMemoryShare);


	if($linksMemoryShare)  #PREG_GREP_INVERT
	{
		echo $txtcl->txtcolor("\n\tSE ENCONTRARON ".count($linksMemoryShare)." CON LA EXPRESION: ".$expLinks."\n",1,"verde1","negro");
		guardadData($linksMemoryShare,"a",$rutaDatalink);


		if($linksMemoryShareInvert){
			echo $txtcl->txtcolor("\tSE ENCONTRARON ".count($linksMemoryShareInvert)." SIN LA EXPRESION, SE GUARDARON : Data_bing/Data_not_Filter.txt \n",1,"verde1","negro");
			guardadData($linksMemoryShareInvert,"a","Data_bing/Data_not_Filter.txt");
		}




	}
	else
	{
		echo $txtcl->txtcolor("\n\tNO SE ENCONTARON LINKS CON LA EXPRESION : \"".$expLinks."\"\n\tSE GUARDARON : Data_bing/Data_not_Filter.txt\n\tCANTIDAD DE LINKS : ".count($linksMemoryShareInvert)."\n",1,"rojo","negro");
		guardadData($linksMemoryShareInvert,"a","Data_bing/Data_not_Filter.txt");
		//print_r($linksMemoryShareInvert);
	}

}
else
{
	//aqui guardamos los link en el txt
	guardadData($linksMemoryShare,"a",$rutaDatalink);
	echo $txtcl->txtcolor("\tSE TERMINO LAS CONSULTAS Y SE ENCONTRARON : ".count($linksMemoryShare)." LINKS\n",1,"verde1","negro");
}




 






?>