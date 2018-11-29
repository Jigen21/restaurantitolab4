<?php
 use \Firebase\JWT\JWT as jwt; 

//require_once './Media.php';
    class MW{


        public function VerificarDelete($request,$response)
        {
            if(isset($request->getParsedBody()['token']))
            {
                return $response;

            }
            else
            {
            return $response->withJson("Error token no seteado",409);
            }


        }




        public function ListadoEmpleado($request,$response)
        {
            $arrayDeMedias= Anteojos::Listado($request,$response);
            $cant= count($arrayDeMedias);
            $arrayColores=array();
            for($i=0;$i<$cant;$i++)
            {
                $response->getBody()->write( $arrayDeMedias[$i]->dni." ".$arrayDeMedias[$i]->nombre ."<br>");
                //array_push($arrayColores,$arrayDeMedias[$i]->color);
            }

            //$resultado=array_unique($arrayColores);
            //return $response;
            //$response->getBody()->write(print_r($arrayColores));
            //$response->getBody()->write("la cantidad de colores diferentes es :");
            $response->getBody()->write(count($resultado));



        }



        public static function ListadoJefe($request,$response)
        {

            $arrayDeMedias= Anteojos::Listado($request,$response);
            $cant= count($arrayDeMedias);
            $arrayColores=array();
            for($i=0;$i<$cant;$i++)
            {
                $response->getBody()->write( $arrayDeMedias[$i]->dni." ".$arrayDeMedias[$i]->nombre ."".$arrayDeMedias[$i]->puesto ."".$arrayDeMedias[$i]->clave ."<br>");
                //array_push($arrayColores,$arrayDeMedias[$i]->color);
            }

            //$resultado=array_unique($arrayColores);
            //return $response;
            //$response->getBody()->write(print_r($arrayColores));
            //$response->getBody()->write("la cantidad de colores diferentes es :");
            //$response->getBody()->write(count($resultado));
            





        }





        public function VerificarSeteados($request,$response,$netx)
        {
           
            if($request->isPost()){
                //devuelve TRUE si var existe y tiene un valor distinto de NULL, FALSE de lo contrario.
                if(isset($request->getParsedBody()['correo']) && isset($request->getParsedBody()['clave'])){ 
                    //$response= MW::VerificarCamposVacios($request,$response,$netx);
                    $response= $netx($request,$response); 
                    return $response;     
                }
                if((isset($request->getParsedBody()['correo'])))
                {
                    return $response->withJson("Error clave no seteada",409);
                }

                if((isset($request->getParsedBody()['clave'])))
                {
                    return $response->withJson("Error correo no seteada",409);
                }

                else
                { 
                    //return $response->withJson(array(["error"=>"valores no seteados"]));
                    return $response->withJson("Error valores no seteados",409);
                }

                return $response;

            }else if($request->isGet()){
                $token = $request->getHeader('token');
                if(isset($token[0])){
                    $response= $netx($request,$response);
                    
                }
                else
                {
                   
                    return $response->withJson("Error valores no seteados",409);
                }
                    return $response;
            }
        }



        public static function VerificarCamposVacios($request,$response,$netx)
        {
            
            if($request->isPost()){
                $correo = $request->getParsedBody()['correo'];
                $clave = $request->getParsedBody()['clave'];


                if(empty($correo) && empty($clave) )
                { 

                return $response->withJson("valores vacios",409);
                
                }
                

                if(empty($correo))
                { 

                return $response->withJson("el correo esta vacio",409);
                
                }

                if(empty($clave))
                { 

                return $response->withJson("la clave esta vacia",409);
                
                }

                


                else
                {
                    
                //  $response=  MW::VerificarBD($request,$response,$netx);
                    $response= $netx($request,$response);
                
                }
                    return $response;
            }
            
            else if($request->isGet())
            {
                    $token = $request->getHeader('token');
                    if(empty($token[0])){

                        return $response->withJson("valores vacios",409);
                    }
                    else
                    {
                        $response= $netx($request,$response);
                    }
                        return $response;
            }
            
        }



        public function VerificarBD($request,$response,$netx){

            $dni = $request->getParsedBody()['dni'];
            $clave = $request->getParsedBody()['clave'];

            $objetoPDO = new PDO('mysql:host=localhost;dbname=final;charset=utf8', "root", "");
                  
                    $sql =$objetoPDO->prepare("SELECT * FROM empleado WHERE dni = :dni AND clave = :clave");
                    $sql->bindValue(':dni', $dni);
                    $sql->bindValue(':clave', $clave);
                    $sql->execute();
                
                    $result = $sql->rowCount();
                

                if($result==1){

                    $response = $netx($request, $response);
                    return $response;

                }else
                {
                  //  return $response->withJson(array(["error"=>"ERROR no se encuentra en la BD"]));
                  
                  return $response->withJson("No se encuentra en la BD",409);
                 
                }
        }




        public function Verificar($request,$response,$next)
        {
            $token=null;

        //$token= $request->getHeader('token');
        //$token=$_DELETE["token"];
        $token = $request->getParsedBody()['token'];
        //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MzI3OTAxMTEsImV4cCI6MTUzMjgwMDExMSwiY29ycmVvIjoicHJvYmJAZ21haWwuY29tIiwicGVyZmlsIjoiUHJvcGlldGFyaW8iLCJhcHAiOiJwcm9iYW5kbyJ9.QCNGbJ5viJDQ_sLn6mbpf33RWgd0nfDgtWfbDeJLXI4";
       //$token=$_GET["token"];
        
        try
        {
            //echo $token;
            $jwtDecode = JWT::decode($token,'miClave',array('HS256'));  
            //$jwtDecode = JWT::decode($token,'miClave',array('HS256')); 
              
                $response = $next($request, $response);
                return $response;
            
           // $response = $netx($request, $response);
               // return $response;
         }
         catch(Exception $e)
         {
            return $response->withJson("token invalido",409);
         }

         
        
        }


        public static function VerificarPropietario($request,$response,$next){
            $token=null;

            if($request->isGet()){
                $token= $request->getHeader('token');
            }else{
                $token= $request->getParsedBody()['token'];
            }

            //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MzI3OTAxMTEsImV4cCI6MTUzMjgwMDExMSwiY29ycmVvIjoicHJvYmJAZ21haWwuY29tIiwicGVyZmlsIjoiUHJvcGlldGFyaW8iLCJhcHAiOiJwcm9iYW5kbyJ9.QCNGbJ5viJDQ_sLn6mbpf33RWgd0nfDgtWfbDeJLXI4";

                if(empty($token) || $token === "")
                {
                    echo "el token esta vacio";
                }
                try
                {
                    echo "asd";
                    $jwtDecode = JWT::decode($token,'miClave',array('HS256'));
                    echo "asd";
      
                    if($jwtDecode->perfil=="propietario" || $jwtDecode->perfil=="Propietario"){
                
                      //  $response = $next($request, $response);
                      $response->withJson("Ok");
                      $response = $next($request, $response);
                      return $response;
                    
                         
                    }else{
                       
                        return $response->withJson("Error,no es un propietario",409);
                    }
                 }
                 catch(Exception $e){
                 
                    return $response->withJson("Error",409);
                 }
        }

        public static function VerificarPropietarioOEncargado($request,$response,$next){
            $token=null;

            if($request->isGet()){
                $token= $request->getHeader('token');
            }else{
                $token= $request->getParsedBody()['token'];
            }

            //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MzI3OTAxMTEsImV4cCI6MTUzMjgwMDExMSwiY29ycmVvIjoicHJvYmJAZ21haWwuY29tIiwicGVyZmlsIjoiUHJvcGlldGFyaW8iLCJhcHAiOiJwcm9iYW5kbyJ9.QCNGbJ5viJDQ_sLn6mbpf33RWgd0nfDgtWfbDeJLXI4";

                if(empty($token) || $token === "")
                {
                    echo "el token esta vacio";
                }
                try
                {
                    echo "asd";
                    $jwtDecode = JWT::decode($token,'miClave',array('HS256'));
                    echo "asd";
      
                    if($jwtDecode->perfil=="propietario" || $jwtDecode->perfil=="Propietario" || $jwtDecode->perfil=="Encargado"||$jwtDecode->perfil=="encargado"){
                
                      //  $response = $next($request, $response);
                      $response->withJson("Ok");
                      $response = $next($request, $response);
                      return $response;
                    
                         
                    }else{
                       
                        return $response->withJson("Error,no es un propietario o encargado",409);
                    }
                 }
                 catch(Exception $e){
                 
                    return $response->withJson("Error",409);
                 }
        }



        public function VerificarEncargado($request,$response,$next){
            $token=null;

            if($request->isGet()){
                $token= $request->getHeader('token');
            }else{
                $token= $request->getParsedBody()['token'];
            }

                if(empty($token) || $token == "")
                {
                    echo "el token esta vacio";
                }
                try
                {
                    $jwtDecode = JWT::decode($token,'miClave',array('HS256'));
                   
                    if($jwtDecode->perfil=="encargado" || $jwtDecode->perfil=="Encargado"){

                        $response->withJson("Ok");
                        $response = $next($request, $response);
                        return $response;                       
        
                    }else{
                       
                        return $response->withJson("Error,no es un encargado",409);
                    
                    }
                 }
                 catch(Exception $e){
                    
                    return $response->withJson("Error",409);
                    
                 }
        }







    }

?>