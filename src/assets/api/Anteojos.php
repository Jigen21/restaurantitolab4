<?php
use \Firebase\JWT\JWT as jwt; 

//INSERT INTO `cuatro` VALUES('id', 'pasivo', 'enie', 'digo')
// asi agrego en phpmyadmin,me ahorro tiempo,el id se escribe solo aunque ponga lo que yo quiera
class Anteojos
{




    function Registrar($request,$response)
    {


        $correo = $request->getParsedBody()['correo'];
        $clave = $request->getParsedBody()['clave'];
        $tipo=  $request->getParsedBody()['tipo'];
      
      

        $db = new PDO('mysql:host=localhost;dbname=id7550260_restaurante;charset=utf8', "id7550260_axel", "Herby1");


            $s =$db->prepare("SELECT * FROM restaurante WHERE correo = :correo");
                $s->bindValue(':correo', $correo, PDO::PARAM_STR);
                $s->execute();  

                //$result = $sql->rowCount();
                //$response->getBody()->write($sql->rowCount());

                $result = $s->rowCount();
                //$resultado = $sql->row();

                if($result==1)
                {
                    $emp = new \stdClass();
                    $emp->correo=$correo;
                    $emp->clave=$clave;
                    

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado ya existe en la base";
                    $empmod->empleado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                   // $response=json_encode($empmod);
                    //return $response;
                    return $response->withJson("no se encuentra en la base de datos",409);


                }






        $s =$db->prepare("INSERT INTO restaurante (correo, clave,tipo)"
                                                . "VALUES(:correo,:clave,:tipo)");
    
            $s->bindValue(':correo', $correo, PDO::PARAM_STR);
            $s->bindValue(':clave', $clave, PDO::PARAM_INT);
            $s->bindValue(':tipo', $tipo, PDO::PARAM_STR);
          
           
           

            $s->execute();  

                $emp = new \stdClass();
                $emp->correo=$correo;
                $emp->clave=$clave;
                

                //$empleado = array(true,"datos agregados con exito",$emp);
                $empleado=json_encode($emp);






                $empmod = new \stdClass();
                $empmod->exito=true;
                $empmod->mensaje="el empleado se pudo agregar";
                $empmod->empleado=$emp;
                //$listad->puesto=$puesto;
 
    //$response=json_encode($arraydeVentas);
                $response=json_encode($empmod);
                return $response;


    }
    
    
    function Login($request,$response)
    {


        $correo = $request->getParsedBody()['correo'];
        $clave = $request->getParsedBody()['clave'];

        //$correo="asd";
        //$clave=123;
       // $nombre = $request->getParsedBody()['nombre'];
       // $puesto = $request->getParsedBody()['puesto'];
        //$color=$_GET['color'];
        //$marca=$_GET['marca'];
        //$precio=$_GET['precio'];
        //$talle=$_GET['talle'];


        //$metodo="get";
        //$ruta="crearUsuario";


        $db = new PDO('mysql:host=localhost;dbname=id7550260_restaurante;charset=utf8', "id7550260_axel", "Herby1");

         $s =$db->prepare("SELECT * FROM restaurante WHERE correo = :correo AND clave = :clave");
                $s->bindValue(':correo', $correo, PDO::PARAM_STR);
                $s->bindValue(':clave', $clave, PDO::PARAM_INT);
                $s->execute();  

                //$result = $sql->rowCount();
                //$response->getBody()->write($sql->rowCount());

                $result = $s->rowCount();
                //$resultado = $sql->row();

                if($result==1)
                {
                /*    $emp = new \stdClass();
                    $emp->correo=$correo;
                    $emp->clave=$clave;
                    

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado se pudo logear";
                    $empmod->empleado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;*/
                    
                    $resultado=$s->fetch();
                
                $correo= $resultado[0];
                $tipo=$resultado[2];
               
                
                $ahora=time();

                $payload = array(
                   'iat' => $ahora,
                   'exp'=> $ahora +(10000),//20 segundos
                   'correo' => $correo,
                   'tipo'=>$tipo,
                   'app' => "probando"
                );
        
                $token = JWT::encode($payload, "miClave");
                
              //  $response->getBody()->write($token);      
                //return $response->withJson($token,200);



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                   

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo logear";
                    $empmod->empleado=$emp;
                    $empmod->empleadoJWT=$token;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($token);
                    return $response;






                }


                $emp = new \stdClass();
                $emp->correo=$correo;
                $emp->clave=$clave;
                

                //$empleado = array(true,"datos agregados con exito",$emp);
                $empleado=json_encode($emp);






                $empmod = new \stdClass();
                $empmod->exito=true;
                $empmod->mensaje="No se pudo logear";
                $empmod->empleado=$emp;
                //$listad->puesto=$puesto;
 
    //$response=json_encode($arraydeVentas);
               // $response=json_encode($empmod);
               return $response->withJson("no se encuentra en la base de datos",409);
               // return $response;


    }

    
	 public function Listado($request,$response)
	{
    

        $arrayDeMedias=array();
        $objetoPDO = new PDO('mysql:host=localhost;dbname=id6888245_axelh21;charset=utf8', "id6888245_axelh21", "axelh21");
        $sql = $objetoPDO->prepare('SELECT * FROM prueba');
        $sql->execute();
        
        while($result = $sql->fetchObject())
        {
            array_push($arrayDeMedias,$result);
        }
      
        $cant= count($arrayDeMedias);
     
        //$response=json_encode($arrayDeMedias);
        //return $response;
        //$nuevoResponse=$response->withJson($arrayDeMedias);

        if($request->isPost())
        {
            return $arrayDeMedias;

        }
        if($request->isGet())
        {
            if($request->getHeader('token'))
            {
                return $arrayDeMedias;
//return
            }

            //$response=json_encode($arrayDeMedias);
            //return $response;
            

            $response=json_encode($arrayDeMedias);
               return $response;
        }


       
            //return $nuevoResponse;
        






    }

    
    function puntajeDos($request,$response)
    {

            $correo = $request->getParsedBody()['correo'];
            $dos = $request->getParsedBody()['dos'];
            $dosViejo = $request->getParsedBody()['dos'];
            


            $db = new PDO('mysql:host=localhost;dbname=id6888245_axelh21;charset=utf8', "id6888245_axelh21", "axelh21");

            $sql =$db->prepare("SELECT * FROM prueba WHERE correo = :correo");
        
                $sql->bindValue(':correo', $correo, PDO::PARAM_STR);
                

                $sql->execute();  

                $result = $sql->rowCount();

                if($result==1)
                {
                    $resultado=$sql->fetch();
                    $correo= $resultado[0];
                    $dosViejo=$resultado[3];
                    
                    if($dosViejo>$dos)
                    {
                         $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="sacaste un puntaje menor que tu maximo";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                    }
                   
                   
                   
                    /*$sql =$db->prepare("DELETE FROM media WHERE id = :id");
                    $sql->bindValue(':id', $id);
                    $sql->execute();*/

                    $sql =$db->prepare("UPDATE prueba SET dos=:dos WHERE correo = :correo");
                    $sql->bindValue(':correo',$correo);
                    $sql->bindValue(':dos',$dos);
                   
                    $sql->execute();
                    



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo modificar";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;




                }
                else
                {
                    //return $response->getBody()->write("Elemento inexistente");

                    $emp = new \stdClass();
                    $emp->dni=$dni;
                    $emp->clave=$clave;
                    $emp->nombre=$nombre;
                    $emp->puesto=$puesto;

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);





                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado no existe";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                }
                //$response->getBody()->write("datos eliminados con exito");

                $response->getBody()->write("Error.");

            
          return $response;




    }
    
    function puntajeTres($request,$response)
    {

            $correo = $request->getParsedBody()['correo'];
            $tres = $request->getParsedBody()['tres'];
            $tresViejo = $request->getParsedBody()['tres'];
            


            $db = new PDO('mysql:host=localhost;dbname=id6888245_axelh21;charset=utf8', "id6888245_axelh21", "axelh21");

            $sql =$db->prepare("SELECT * FROM prueba WHERE correo = :correo");
        
                $sql->bindValue(':correo', $correo, PDO::PARAM_STR);
                

                $sql->execute();  

                $result = $sql->rowCount();

                if($result==1)
                {
                    $resultado=$sql->fetch();
                    $correo= $resultado[0];
                    $tresViejo=$resultado[4];
                    
                    if($tresViejo>$tres)
                    {
                         $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="sacaste un puntaje menor que tu maximo";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                    }
                   
                   
                   
                    /*$sql =$db->prepare("DELETE FROM media WHERE id = :id");
                    $sql->bindValue(':id', $id);
                    $sql->execute();*/

                    $sql =$db->prepare("UPDATE prueba SET tres=:tres WHERE correo = :correo");
                    $sql->bindValue(':correo',$correo);
                    $sql->bindValue(':tres',$tres);
                   
                    $sql->execute();
                    



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo modificar";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;




                }
                else
                {
                    //return $response->getBody()->write("Elemento inexistente");

                    $emp = new \stdClass();
                    $emp->dni=$dni;
                    $emp->clave=$clave;
                    $emp->nombre=$nombre;
                    $emp->puesto=$puesto;

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);





                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado no existe";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                }
                //$response->getBody()->write("datos eliminados con exito");

                $response->getBody()->write("Error.");

            
          return $response;




    }
    
    function puntajeCuatro($request,$response)
    {

            $correo = $request->getParsedBody()['correo'];
            $cuatro = $request->getParsedBody()['cuatro'];
            $cuatroViejo = $request->getParsedBody()['cuatro'];
            


            $db = new PDO('mysql:host=localhost;dbname=id6888245_axelh21;charset=utf8', "id6888245_axelh21", "axelh21");

            $sql =$db->prepare("SELECT * FROM prueba WHERE correo = :correo");
        
                $sql->bindValue(':correo', $correo, PDO::PARAM_STR);
                

                $sql->execute();  

                $result = $sql->rowCount();

                if($result==1)
                {
                    $resultado=$sql->fetch();
                    $correo= $resultado[0];
                    $cuatroViejo=$resultado[5];
                    
                    if($cuatroViejo>$cuatro)
                    {
                         $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="sacaste un puntaje menor que tu maximo";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                    }
                   
                   
                   
                    /*$sql =$db->prepare("DELETE FROM media WHERE id = :id");
                    $sql->bindValue(':id', $id);
                    $sql->execute();*/

                    $sql =$db->prepare("UPDATE prueba SET cuatro=:cuatro WHERE correo = :correo");
                    $sql->bindValue(':correo',$correo);
                    $sql->bindValue(':cuatro',$cuatro);
                   
                    $sql->execute();
                    



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo modificar";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;




                }
                else
                {
                    //return $response->getBody()->write("Elemento inexistente");

                    $emp = new \stdClass();
                    $emp->dni=$dni;
                    $emp->clave=$clave;
                    $emp->nombre=$nombre;
                    $emp->puesto=$puesto;

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);





                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado no existe";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                }
                //$response->getBody()->write("datos eliminados con exito");

                $response->getBody()->write("Error.");

            
          return $response;




    }
    
    function puntajeUno($request,$response)
    {

            $correo = $request->getParsedBody()['correo'];
            $uno = $request->getParsedBody()['uno'];
            $unoViejo = $request->getParsedBody()['uno'];
            


            $db = new PDO('mysql:host=localhost;dbname=id6888245_axelh21;charset=utf8', "id6888245_axelh21", "axelh21");

            $sql =$db->prepare("SELECT * FROM prueba WHERE correo = :correo");
        
                $sql->bindValue(':correo', $correo, PDO::PARAM_STR);
                

                $sql->execute();  

                $result = $sql->rowCount();

                if($result==1)
                {
                    $resultado=$sql->fetch();
                    $correo= $resultado[0];
                    $unoViejo=$resultado[2];
                    
                    if($unoViejo>$uno)
                    {
                         $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="sacaste un puntaje menor que tu maximo";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                    }
                   
                   
                   
                    /*$sql =$db->prepare("DELETE FROM media WHERE id = :id");
                    $sql->bindValue(':id', $id);
                    $sql->execute();*/

                    $sql =$db->prepare("UPDATE prueba SET uno=:uno WHERE correo = :correo");
                    $sql->bindValue(':correo',$correo);
                    $sql->bindValue(':uno',$uno);
                   
                    $sql->execute();
                    



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo modificar";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;




                }
                else
                {
                    //return $response->getBody()->write("Elemento inexistente");

                    $emp = new \stdClass();
                    $emp->dni=$dni;
                    $emp->clave=$clave;
                    $emp->nombre=$nombre;
                    $emp->puesto=$puesto;

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);





                    $empmod = new \stdClass();
                    $empmod->exito=false;
                    $empmod->mensaje="el empleado no existe";
                    $empmod->empleadoModificado=$emp;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;

                }
                //$response->getBody()->write("datos eliminados con exito");

                $response->getBody()->write("Error.");

            
          return $response;




    }

}