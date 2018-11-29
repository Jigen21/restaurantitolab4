<?php

require_once './vendor/autoload.php';
use \Firebase\JWT\JWT as jwt;


class Usuario
{
	


	function Agregar($request,$response,$next)
	{
        $validarPerfil=0;
            $correo = $request->getParsedBody()['correo'];
            $clave = $request->getParsedBody()['clave'];
            $nombre = $request->getParsedBody()['nombre'];
            $apellido = $request->getParsedBody()['apellido'];
            $perfil = $request->getParsedBody()['perfil'];
            //$foto = $request->getParsedBody()['foto'];


            if($perfil == "propietario" || $perfil == "Propietario")
            {
                $validarPerfil=1;
            }

            if($perfil == "empleado" || $perfil == "Empleado")
            {
                $validarPerfil=1;
            }

            if($perfil == "encargado" || $perfil == "Encargado")
            {
                $validarPerfil=1;
            }

            if($validarPerfil==0)
            {
                return $response->withJson("Error,el perfil tiene que ser empleado,encargado o propietario");

            }



            $db = new PDO('mysql:host=localhost;dbname=opticabd;charset=utf8', "root", "");



                $s =$db->prepare("SELECT * FROM usuarios WHERE correo = :correo");
                $s->bindValue(':correo', $correo, PDO::PARAM_STR);
                $s->execute();  

                //$result = $sql->rowCount();
                //$response->getBody()->write($sql->rowCount());

                $result = $s->rowCount();
                //$resultado = $sql->row();

                if($result==1)
                {
                    return $response->withJson("Error,el correo ya existe en la base de datos");

                }




            $tmp_file = $_FILES['foto']['tmp_name'];
            $img_name =$_FILES['foto']['name'];
            $upload_dir="./fotos/".$img_name;
            
            if (move_uploaded_file($tmp_file,$upload_dir)) {
                //$response="adasdd";
              }else{
                
              }


            //$metodo="get";
            //$ruta="crearUsuario";


            //$db = new PDO('mysql:host=localhost;dbname=merceriabd;charset=utf8', "root", "");











            $s =$db->prepare("INSERT INTO usuarios (id, correo, clave, nombre , apellido ,perfil , foto)"
                                                    . "VALUES(NULL,:correo, :clave, :nombre,:apellido,:perfil,:foto)");
        
                $s->bindValue(':correo', $correo, PDO::PARAM_STR);
                $s->bindValue(':clave', $clave, PDO::PARAM_INT);
                $s->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $s->bindValue(':apellido', $apellido, PDO::PARAM_STR);
                $s->bindValue(':perfil', $perfil, PDO::PARAM_STR);
                $s->bindValue(':foto', $img_name, PDO::PARAM_STR);

                $s->execute();  
                
                $response->getBody()->write("datos agregados con exito");

            
          return $response;
        


    }

	 function Listado($request,$response)
	{
    

        $arraydeVentas=array();
        $objetoPDO = new PDO('mysql:host=localhost;dbname=final;charset=utf8', "root", "");
        $sql = $objetoPDO->prepare('SELECT * FROM empleado');
        $sql->execute();
        
        while($result = $sql->fetchObject())
        {
            array_push($arraydeVentas,$result);
        }
      
        $cant= count($arraydeVentas);

        if($cant==0)
        {
            //return $response;
            $listad = new \stdClass();
                    $listad->exito=false;
                    $listad->mensaje="el listado esta vacio";
                    $listad->listado=null;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
        $response=json_encode($listad);
        return $response;
        }


        //$listado=array(true,"listado",$arraydeVentas);

                    $listad = new \stdClass();
                    $listad->exito=true;
                    $listad->mensaje="el listado de los empleados";
                    $listad->listado=$arraydeVentas;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
        $response=json_encode($listad);
        return $response;
        






    }
    
    function Crear($request,$response)
    {
        
        
        $dni = $request->getParsedBody()['dni'];
        $clave = $request->getParsedBody()['clave'];


        $usuario='root';
        $pass='';
        $objetoPDO = new PDO('mysql:host=localhost;dbname=final;charset=utf8', $usuario, $pass);
        $sql=$objetoPDO->prepare('SELECT dni,clave,nombre,puesto  FROM `empleado` WHERE `dni` = :dni AND `clave` = :clave');
        $sql->bindValue(':dni', $dni);
        $sql->bindValue(':clave', $clave);
        $sql->execute();
        $result = $sql->rowCount();






        /*$ahora=time();
        //$response=$next($request,$response);
        //$response->getBody()->write("si existe");
        //$response->getBody()->write('<br>bienvenido'.$nombre.'con clave'.$clave.'<br>');
        $datos=$request->getParsedBody();

        $payload = array(
        'iat' => $ahora,
        'exp'=> $ahora +(100000),
        'data' => $datos,
        'perfil'=>$perfil,
        'app' => "probando"
          );

                $token = JWT::encode($payload, "miClave");

            return $response->withJson($token,200);*/
            if($result)
            {
                $resultado=$sql->fetch();
                
                $dni= $resultado[0];
                $puesto=$resultado[3];
                $nombre=$resultado[2];
                
                $ahora=time();

                $payload = array(
                   'iat' => $ahora,
                   'exp'=> $ahora +(10000),//20 segundos
                   'dni' => $dni,
                   'nombre'=>$nombre,
                   'puesto'=>$puesto,
                   'app' => "probando"
                );
        
                $token = JWT::encode($payload, "miClave");
                
              //  $response->getBody()->write($token);      
                //return $response->withJson($token,200);



                    $emp = new \stdClass();
                    $emp->dni=$resultado[0];
                    $emp->clave=$resultado[1];
                    $emp->nombre=$resultado[2];
                    $emp->puesto=$resultado[3];

                    //$empleado = array(true,"datos agregados con exito",$emp);
                    $empleado=json_encode($emp);






                    $empmod = new \stdClass();
                    $empmod->exito=true;
                    $empmod->mensaje="el empleado se pudo logear";
                    $empmod->empleado=$emp;
                    $empmod->empleadoJWT=$token;
                    //$listad->puesto=$puesto;
     
        //$response=json_encode($arraydeVentas);
                    $response=json_encode($empmod);
                    return $response;






            }
            else
            {
                return $response->withJson("Error");
            }
                    





    }

    public function Verificar($request,$response)
    {

        $token= $request->getHeader('token');
       //$token=$_GET["token"];
        if(empty($token[0])|| $token[0] === "")
        {
            echo "el token esta vacio";
        }
        try
        {
            $jwtDecode = JWT::decode($token[0],'miClave',array('HS256'));
         }
         catch(Exception $e){
            $nuevoResponse=$response->withJson("Token invalido",409);
            return $nuevoResponse;
         }

         return $response->withJson("token valido",200);
        
        }


    function Verificarr($request,$response,$next)
    {
        
        //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MzA1MzcyMzEsImV4cCI6MTUzMDYzNzIzMSwiZGF0YSI6eyJjb3JyZW8iOiJhc2Rhc2RAcHJvYmFuZG8uY29tIiwiY2xhdmUiOiIxMjMifSwiYXBwIjoicHJvYmFuZG8ifQ.6Pwru-P1A-g9tPv7FYbgDK64cNKlfP_nf6onHQiwM64";

        $token=$_GET["token"];

        //echo "llegue aca";


        try
        {
            
            
            $payload=JWT::decode(
                $token,
                'miClave',
                ['HS256']
              )->data;

              echo "llegue aca";

              //$correo=$payload["correo"];
              $correo=$payload->correo;

              $objetoPDO = new PDO('mysql:host=localhost;dbname=merceriabddos;charset=utf8', "root", "");
              $sql = $objetoPDO->prepare('SELECT * FROM usuario WHERE correo=:correo');

              $sql->bindValue(':correo', $correo, PDO::PARAM_STR);

              $sql->execute();
              
              $result = $sql->fetchObject();

              
              

              return $response->withJson($result,200);

            }

            catch(Exception $e)
            {
                return $response->withJson("no se encuentra en la base de datos",409);

            }


         

        

 

    }

}