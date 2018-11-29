<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
 header("Access-Control-Allow-Headers: Content-Type");
 header("Allow: GET,POST,PUT,OPTIONS");


use \Firebase\JWT\JWT as jwt; 

require_once './vendor/autoload.php';
//require '../composer/vendor/autoload.php';

/*require '../composer/vendor/autoload.php';
require_once './Entidades/bd/AccesoDatos.php';
require_once './Entidades/bicicletaApi.php';
require_once './Entidades/usuarioApi.php';
require_once './Entidades/ventaApi.php';
require_once './Entidades/AutentificadorJWT.php';
require_once './Entidades/MWparaCORS.php';
require_once './Entidades/MWparaAutentificar.php';*/

require_once './AccesoDatos.php';
require_once './Anteojos.php';
require_once './Usuario.php';
require_once './mw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);


$app->get('/productos/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->nombre=$value['nombre'];
        $obj->tipo=$value['tipo'];
        $obj->precio=$value['precio'];
        $obj->tiempo=$value['tiempo'];
        $obj->imagen=$value['imagen'];
        $obj->cantidad=$value['cantidad'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->get('/mesas/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->id=$value['id'];
        $obj->estado=$value['estado'];
        $obj->cliente=$value['cliente'];
        $obj->mozo=$value['mozo'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/ocuparMesa/', function (Request $request, Response $response) { 
    $id = $request->getParsedBody()['id'];
    $correo = $request->getParsedBody()['correo'];
    $estado="ocupada";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado=:estado,cliente=:cliente WHERE id=:id");
    $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
    $consulta->bindValue(':cliente',$correo, PDO::PARAM_STR);
    $consulta->execute();
    return $consulta;
});

$app->post('/guardarProductos/', function (Request $request, Response $response) {
    //$array=$request->getParsedBody();
   // $obj=new stdclass();
    //$obj->id=$array['id'];
   // $obj->idProducto=$array['idProducto'];
   
   
   
   // $obj->cantidad=$array['cantidad'];
   
   $correo=$request->getParsedBody()['correo'];
   $nombre=$request->getParsedBody()['nombre'];
   // $id=1;
    //$cantidad=$request->getParsedBody()['cantidad'];
    //$cantidad=6;
    $cantidad=$request->getParsedBody()['cantidad'];
    $precio=$request->getParsedBody()['precio'];
    $tiempo=$request->getParsedBody()['tiempo'];
    $tipo=$request->getParsedBody()['tipo'];
   
   
   $db = new PDO('mysql:host=localhost;dbname=id7550260_restaurante;charset=utf8', "id7550260_axel", "Herby1");



                $s =$db->prepare("SELECT * FROM mesas WHERE cliente = :correo");
                $s->bindValue(':correo', $correo, PDO::PARAM_STR);
                $s->execute();  

                //$result = $sql->rowCount();
                //$response->getBody()->write($sql->rowCount());

                $result = $s->rowCount();
                //$resultado = $sql->row();

                if($result)
                {
                    
                    $resultado=$s->fetch();
                
                    $id= $resultado[0];
                    
                     $cantidad=$request->getParsedBody()['cantidad'];
                    $precio=$request->getParsedBody()['precio'];
                    $tiempo=$request->getParsedBody()['tiempo'];
                    $tipo=$request->getParsedBody()['tipo'];
                    
                    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `pedidos_productos` VALUES (:id, :nombre, :cantidad, 'pedido',:tipo,:precio,:tiempo);");
                    $consulta->bindValue(':id',  $id, PDO::PARAM_INT);
                    $consulta->bindValue(':nombre',  $nombre, PDO::PARAM_STR);
                    $consulta->bindValue(':cantidad',  $cantidad, PDO::PARAM_INT);
                    $consulta->bindValue(':precio',  $precio, PDO::PARAM_INT);
                    $consulta->bindValue(':tiempo',  $tiempo, PDO::PARAM_INT);
                    $consulta->bindValue(':tipo',  $tipo, PDO::PARAM_STR);
                    $consulta->execute();
                    return $consulta;
                    
   
                }
   
   
   
   // $nombre=$request->getParsedBody()['nombre'];
   // $id=1;
    //$cantidad=$request->getParsedBody()['cantidad'];
    //$cantidad=6;
   /* $cantidad=$request->getParsedBody()['cantidad'];
    $precio=$request->getParsedBody()['precio'];
    $tiempo=$request->getParsedBody()['tiempo'];
    $tipo=$request->getParsedBody()['tipo'];
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `pedidos_productos` VALUES (:id, :nombre, :cantidad, 'pedido',:tipo,:precio,:tiempo);");
    $consulta->bindValue(':id',  $id, PDO::PARAM_INT);
    $consulta->bindValue(':nombre',  $nombre, PDO::PARAM_STR);
    $consulta->bindValue(':cantidad',  $cantidad, PDO::PARAM_INT);
    $consulta->bindValue(':precio',  $precio, PDO::PARAM_INT);
    $consulta->bindValue(':tiempo',  $tiempo, PDO::PARAM_INT);
    $consulta->bindValue(':tipo',  $tipo, PDO::PARAM_STR);
    $consulta->execute();
    return $consulta;*/
});

$app->get('/verPedidos/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos_productos");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->id=$value['id'];
        $obj->nombre=$value['nombre'];
        $obj->estado=$value['estado'];
        $obj->cantidad=$value['cantidad'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/verPedidos/', function (Request $request, Response $response) {
    
    $tipo=$request->getParsedBody()['tipo'];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos_productos WHERE tipo = '$tipo'");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->id=$value['id'];
        $obj->nombre=$value['nombre'];
        $obj->estado=$value['estado'];
        $obj->cantidad=$value['cantidad'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/terminarPedido/', function (Request $request, Response $response) { 
    $id = $request->getParsedBody()['id'];
    $tipo = $request->getParsedBody()['tipo'];
    $estado="terminado";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedidos_productos SET estado=:estado WHERE id=:id AND tipo=:tipo");
    $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:tipo");
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
    
    
    
    return $consulta;
});


$app->post('/estoySentado/', function (Request $request, Response $response) { 
    $nombre = $request->getParsedBody()['nombre'];
   // $tipo = $request->getParsedBody()['tipo'];
   // $estado="terminado";
    
   // $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
   // $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas");
   // $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
   // $consulta->bindValue(':id',$id, PDO::PARAM_STR);
   // $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    //$consulta->execute();
   // return $consulta;
   
   
      $db = new PDO('mysql:host=localhost;dbname=id7550260_restaurante;charset=utf8', "id7550260_axel", "Herby1");



                $s =$db->prepare("SELECT * FROM mesas WHERE cliente = :nombre");
                $s->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $s->execute();  

                //$result = $sql->rowCount();
                //$response->getBody()->write($sql->rowCount());

                $result = $s->rowCount();
                //$resultado = $sql->row();

                if($result)
                {
                   // return $response->withJson("ya esta sentado");
                  // return "asd";
                    //return "si";
                     return $response->withJson("si");

                }
                return $response->withJson("no");
                
               // return "dsa";

   
});

$app->post('/entregarPedido/', function (Request $request, Response $response) { 
    
    $id = $request->getParsedBody()['id'];
   // $tipo = $request->getParsedBody()['tipo'];
    $estado="tomado";
    $estadoDos="terminado";
    $estadoTres="entregado";
    $tipo="mozo";
    
    $db = new PDO('mysql:host=localhost;dbname=id7550260_restaurante;charset=utf8', "id7550260_axel", "Herby1");



                $s =$db->prepare("SELECT * FROM pedidos_productos WHERE id = :id AND estado = 'tomado'");
                $s->bindValue(':id', $id, PDO::PARAM_STR);
               // $s->bindValue(':estado', $estado, PDO::PARAM_STR);
                $s->execute();  
                $result = $s->rowCount();
               

                if($result)
                {
                   
                    // return $response->withJson("FALTA TERMINAR PEDIDOS");
                     return $response->withJson("Falta terminar pedidos");
                     
                   
                }
                
                else
                {
                     $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedidos_productos SET estado=:estadoTres WHERE id=:id AND estado=:estadoDos" );
                    $consulta->bindValue(':estadoDos',$estadoDos, PDO::PARAM_STR);
                    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
                    $consulta->bindValue(':estadoTres',$estadoTres, PDO::PARAM_STR);
                    //$consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
                    $consulta->execute();
                    //return $consulta;
                    
                     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:tipo");
                        $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
                        $consulta->execute();
                    
                   // return $response->withJson("PEDIDOS ENTREGADOS");
                    return $response->withJson("Pedidos Entregados Con Exito");

                    
                }
    
    
    
    
    
   
});

$app->get('/traerEmpleados/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM restaurante");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->nombre=$value['correo'];
        $obj->tipo=$value['tipo'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/alta/', function (Request $request, Response $response) { 
    $correo = $request->getParsedBody()['correo'];
    $password = $request->getParsedBody()['password'];
    $tipo = $request->getParsedBody()['tipo'];
    $super="supervisor";
    //$estado="terminado";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
   $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `restaurante` VALUES (:correo, :password, :tipo,'');");
    $consulta->bindValue(':correo',$correo, PDO::PARAM_STR);
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->bindValue(':password',$password, PDO::PARAM_STR);
    $consulta->execute();
    
     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:super");
    $consulta->bindValue(':super',$super, PDO::PARAM_STR);
    $consulta->execute();
    
    
    
    
    
    
    return $consulta;
});

$app->post('/tomado/', function (Request $request, Response $response) { 
    $id = $request->getParsedBody()['id'];
   // $tipo = $request->getParsedBody()['tipo'];
    $estado="pedido";
    $estadoDos="tomado";
    $tipo="mozo";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedidos_productos SET estado=:estadoDos WHERE id=:id AND estado=:estado");
    $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
    $consulta->bindValue(':estadoDos',$estadoDos, PDO::PARAM_STR);
    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
   // $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:tipo");
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
    
    
    return $consulta;
});

$app->post('/traerTotal/', function (Request $request, Response $response) {    
   $nombre = $request->getParsedBody()['nombre'];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE cliente=:nombre");
    $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
    $consulta->execute(); 
    $result = $consulta->rowCount();
                //$resultado = $sql->row();

                if($result==1)
                {
               
                    
                $resultado=$consulta->fetch();
                
                $id= $resultado[0];
                
                $consultaa = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos_productos WHERE id=:id");
                $consultaa->bindValue(':id',$id, PDO::PARAM_STR);
                $consultaa->execute(); 
                
                $consultaa->execute();
                $datos=$consultaa->fetchall();
                $arrayJson=array();
                foreach($datos as $value) 
                {
                    $obj=new stdclass();
                    $obj->nombre=$value['nombre'];
                    $obj->precio=$value['precio'];
                    $obj->estado=$value['estado'];
                    
                    $arrayJson[]=$obj;
                }
                return json_encode($arrayJson);
                
                
               
    
                }
    
    
   /* $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->nombre=$value['nombre'];
        $obj->precio=$value['precio'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);*/
  
});

$app->post('/registrarCliente/', function (Request $request, Response $response) { 
    $correo = $request->getParsedBody()['correo'];
    $password = $request->getParsedBody()['password'];
    $tipo = $request->getParsedBody()['tipo'];
    //$estado="terminado";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
   $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `restaurante` VALUES (:correo, :password, :tipo,'');");
    $consulta->bindValue(':correo',$correo, PDO::PARAM_STR);
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->bindValue(':password',$password, PDO::PARAM_STR);
    $consulta->execute();
    return $consulta;
});


$app->post('/pagar/', function (Request $request, Response $response) { 
    $nombre = $request->getParsedBody()['nombre'];
    $estado="pagado";
   
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado=:estado WHERE cliente=:nombre");
    $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
   // $consulta->bindValue(':estadoDos',$estadoDos, PDO::PARAM_STR);
    $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
   // $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    return $consulta;
});

$app->post('/liberarMesa/', function (Request $request, Response $response) { 
    $id = $request->getParsedBody()['id'];
    $estado="libre";
    $cliente="";
   
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado=:estado,cliente=:cliente WHERE id=:id");
    $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
   // $consulta->bindValue(':estadoDos',$estadoDos, PDO::PARAM_STR);
    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
    $consulta->bindValue(':cliente',$cliente, PDO::PARAM_STR);
    $consulta->execute();
    //return $consulta;
    
    $id = $request->getParsedBody()['id'];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM pedidos_productos WHERE id=:id");
    $consulta->bindValue(':id',$id, PDO::PARAM_STR);
    $consulta->execute();
    
    $tipo="mozo";
    
     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:tipo");
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
    
    return $consulta;
});


$app->post('/estadoPedido/', function (Request $request, Response $response) {
    
    $nombre = $request->getParsedBody()['nombre'];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE cliente=:nombre");
    $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
    $consulta->execute(); 
    $result = $consulta->rowCount();
                //$resultado = $sql->row();

                if($result==1)
                {
               
                    
                $resultado=$consulta->fetch();
                
                $id= $resultado[0];
                
                $consultaa = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos_productos WHERE id=:id");
                $consultaa->bindValue(':id',$id, PDO::PARAM_STR);
                $consultaa->execute(); 
                
                $consultaa->execute();
                $datos=$consultaa->fetchall();
                $arrayJson=array();
                foreach($datos as $value) 
                {
                    $obj=new stdclass();
                    $obj->nombre=$value['nombre'];
                    $obj->precio=$value['precio'];
                    $obj->estado=$value['estado'];
                    $obj->tiempo=$value['tiempo'];
                    
                    $arrayJson[]=$obj;
                }
                return json_encode($arrayJson);
                
                
               
    
                }
    
});

$app->post('/eliminarEmpleado/', function (Request $request, Response $response) { 
    //$id = $request->getParsedBody()['id'];
    $nombre = $request->getParsedBody()['nombre'];
    //$estado="terminado";
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM restaurante WHERE correo=:nombre");
  //  $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
   // $consulta->bindValue(':id',$id, PDO::PARAM_STR);
    $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
    $consulta->execute();
    
    $tipo="supervisor";
     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operaciones SET cantidad = cantidad + 1 WHERE operaciones=:tipo");
    $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
    $consulta->execute();
    
    
    
    return $consulta;
});



$app->get('/traerFechas/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM fechas");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->correo=$value['correo'];
        $obj->fecha=$value['fecha'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->get('/traerOperaciones/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM operaciones");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->operaciones=$value['operaciones'];
        $obj->cantidad=$value['cantidad'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/operacionEmpleado/', function (Request $request, Response $response) { 
    
     $correo = $request->getParsedBody()['correo'];
    //$tipo="supervisor";
     $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE restaurante SET cantidad = cantidad + 1 WHERE operaciones=:correo");
    $consulta->bindValue(':correo',$correo, PDO::PARAM_STR);
    $consulta->execute();

  
});







$app->group('/puntajeUno',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::puntajeUno($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
  
   $this->get('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::Listado($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
    
    
    

});

$app->group('/puntajeDos',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::puntajeDos($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
  
  
    
    
    

});

$app->group('/puntajeCuatro',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::puntajeCuatro($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
  
  
    
    
    

});

$app->group('/puntajeTres',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::puntajeTres($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
  
  
    
    
    

});



$app->group('/registrar',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::Registrar($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
    
    
    

});

$app->group('/login',function()
{
    $this->post('[/]', function (Request $request, Response $response) { 
  
  
    ///echo Anteojos::Agregar($request,$response);
    echo Anteojos::Login($request,$response);
    //$response->getBody()->write("Empleado Agregado");
    return $response;



  });
    
    
    

});



$app->get('[/]', function (Request $request, Response $response) { 
  
   
   
   
    $response->getBody()->write("Listado de usuarios");
    return $response;



});




  




            

            

            




$app->group('/listados',function(){

  $this->get('[/]', function (Request $request, Response $response) { 
     /* $token = $request->getParsedBody()['token'];
      $encargado=Anteojo::EsEncargado($token);
    
      $arrayDeMedias= Anteojo::TraerTodosAnteojos($request,$response);
      if($encargado){
          //todos los datos menos el ID del listado
        
        $cant= count($arrayDeMedias);
         for($i=0;$i<$cant;$i++){
          $response->getBody()->write(  $arrayDeMedias[$i]->color." ".$arrayDeMedias[$i]->marca ." ".$arrayDeMedias[$i]->aumento." ".$arrayDeMedias[$i]->precio."<br>");
         }*/

         /*$arrayDeMedias= Media::Listado($request,$response);
         $cant= count($arrayDeMedias);
         for($i=0;$i<$cant;$i++)
         {
          $response->getBody()->write(  $arrayDeMedias[$i]->color." ".$arrayDeMedias[$i]->marca ." ".$arrayDeMedias[$i]->precio." ".$arrayDeMedias[$i]->talle."<br>");
         }*/


         //$token = $request->getParsedBody()['token'];
         $token= $request->getHeader('token');
         //$id= $request->getHeader('id');

         $encargado=Anteojos::EsEncargado($token);
         $propietario=Anteojos::EsPropietario($token);

         if($encargado)
         {
            echo mw::ListadoEncargado($request,$response);
            echo Anteojos::ListadoVentas($request,$response);
           //$this->get('/', \Media::class . ':Listado');
           //echo Media::Listado($request,$response);

          /* $arrayDeMedias= Media::Listado($request,$response);
            $cant= count($arrayDeMedias);
            $arrayColores=array();
            for($i=0;$i<$cant;$i++)
            {
                $response->getBody()->write( $arrayDeMedias[$i]->color." ".$arrayDeMedias[$i]->marca ." ".$arrayDeMedias[$i]->precio." ".$arrayDeMedias[$i]->talle."<br>");
                array_push($arrayColores,$arrayDeMedias[$i]->color);
            }*/





         }
         else if($propietario)
         {
           echo mw::ListadoPropietario($request,$response);
         }
         else
         {
                echo "Tiene que ser propietario o encargado";
         }
         


         
         //echo "<br>";

         

     
       
      
    });

 
  });



$app->run();