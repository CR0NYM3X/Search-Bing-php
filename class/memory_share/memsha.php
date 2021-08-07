<?php



# open  shared memory
function openSM($msj,$id)   // { dato que quiero compartir } {System's id for the shared memory block. }
{
	

	$typeMsj=serialize($msj);
	$msjSize = strlen($typeMsj);
	$shared_id = shmop_open($id,"c",0644,$msjSize);


   if(!$shared_id)
   {
        die("\nError al crear la memoria compartida en el hijo ".getmypid()." habilitar la opcion [ -fk ]\n");
   }
   else
   {

   		 if($msjSize != shmop_write($shared_id, $typeMsj, 0))
        {
            die("\nError al intentar escribir el numero $num en el hijo ".getmypid()." habilitar la opcion [ -fk ]\n");
        }
        else
        {

            shmop_close($shared_id);
        	return true;
        }

   }


}





function getSM($id)
{



   //Abrimos la memoria compartida con nuestro hijo $pid
    $shared_id = shmop_open($id,"a",0666,0); // tambien funciona poniendo , 0, 0
    
	if (!empty($shared_id)) {

   		$share_data = shmop_read($shared_id,0,shmop_size($shared_id));
	    
	    //Marcamos el bloque para que sea eliminado y lo cerramos
	    shmop_delete($shared_id);
	    shmop_close($shared_id);
	    return unserialize($share_data);


	} else {
	            die("\n... La memoria no existe  habilitar la opcion [ -fk ]\n");
	}

}


/*
$id= getmypid();

//openSM(["joto"=>"hombre","perro"=>"chihuhua"],$id);
//openSM("aasdasda)",$id);
openSM('{"jose":"homre","perro":"loco"}',$id);
print_r( getSM($id) ); 

*/





?>