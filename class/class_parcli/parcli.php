<?php

#tiempo de ejecucions
#set_time_limit(0);
//require_once("C:/xampp/htdocs/FileOld/hack/bingFind/class/color_cli/class_color.php");	// darle color al scrpit

//require_once(getcwd()."/class/color_cli/class_color.php");


class parcli
{

	private $varBanner= "\n\n";
	private $varOption= [];
	private $allArgs=	[];
	private $varHelp= "[ -H\t|\t--help\t]\tSirve para ver la ayuda.\n";
	private $varArgv;
	private $description;
	private $varHowRun;


	function __construct($howRun=false)
	{
		if($howRun)
			$this->varHowRun= "\n\t".$howRun."\n";
	}
	

	public function setBanner($parBanner)
	{
		$this->varBanner= "\n".$parBanner."\n\n";
	}


	public function setDescription($_description)
	{
		$this->description= "\t".$_description."\n\n";
	}


	public function getBanner()
	{
		return $this->varBanner;
	}


	public function setArgv($_argv)
	{
		$this->varArgv= $_argv;

		if(count($_argv)==1 || in_array("-h", $_argv) || in_array("-H", $_argv) || in_array("--help", $_argv) || in_array("-help", $_argv))
		{
			echo $this->varBanner;
			echo $this->description;
			echo $this->varHelp;
			echo $this->varHowRun;

		}
		else
		{
			//echo "\n\n-> ";
		}
	}


	public function getArgv()
	{

	}

	public function setParam($param1,$param2,$type="String",$help,$required=null,$dest=null)
	{
		$txt = new Color_texto();

		$this->varHelp.= "[ $param1\t|\t$param2\t]\033[91m {".$type."}\033[0m\t$help\n";
	}


	function __destruct()
	{
		unset($this->varBanner);
		unset($this->varOption);
		unset($this->varHelp);
		unset($this->varArgv);
	}
	
}


#la clase tiene que regresar los argv  en un array multidimencional identificado por nombre el cual el nombre es el parametro que ingresamos

/* ejemplo de actualizacion
php misScript.php argumento1= contenido argumento2= contenido2


el parse tiene que regresar un array como este 
array("argumento1"-> "Contenido", "argumento2"-> "Contenido2")

parametros para actualizacion,
dest=argumento1		"nombre con el cual lo queremos identificar en el array"
type=String 		"el tipo el cual tiene que contener la variable"
default="numero 0"	"si al parametro no se le pasa un argumento se le asigna uno por degault"
nArgs=2				"limite de argumentos que permite el script"

*/





#$p= new parcli('Uso: php '.$argv[0].' -u <URL> -p <PORT> -set <setRESS>');
#$p->setBanner("\tEste es el Banner que utilizara el Script");
//echo $p->getBanner();
#$p->setDescription("Esta es una pequeña descripcion para este ejemplo");
#$p->setParam(/*Parametro 1*/	'-U',/*Parametro 2 opcional*/	'--url',/*Tipo*/	'string',/*Help*/	'Este parametro sirve para poner la URL web',/*Required*/ false,/*Item de Array*/	'url');
#$p->setParam(/*Parametro 1*/	'-A',/*Parametro 2 opcional*/	'--ads',/*Tipo*/	'string',/*Help*/	'Sirve para agregar la direccion IP',/*Required*/ false,/*Item de Array*/	'url');
#$p->setParam(/*Parametro 1*/	'-D',/*Parametro 2 opcional*/	'--dns',/*Tipo*/	'string',/*Help*/	'Con esto obtendremos el DNS',/*Required*/ false,/*Item de Array*/	'url');
#$p->setArgv($argv);

