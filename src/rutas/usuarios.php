<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los usuarios 
$app->get('/api/usuarios', function(Request $request, Response $response){
  $sql = "SELECT * FROM usuarios";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $usuarios = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($usuarios);
    }else {
      echo json_encode("No existen usuarios en la BBDD.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET Recueperar usuario por ID 
$app->get('/api/usuarios/{id}', function(Request $request, Response $response){
  $id_cliente = $request->getAttribute('id');
  $sql = "SELECT * FROM usuarios WHERE id = $id_cliente";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($usuario);
    }else {
      echo json_encode("No existen usuarios en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// POST Crear nuevo usuario 
$app->post('/api/usuarios/nuevo', function(Request $request, Response $response){
   $nombre = $request->getParam('nombre');
   $apellidos = $request->getParam('apellidos');
   $telefono = $request->getParam('telefono');
   $email = $request->getParam('email');
   $direccion = $request->getParam('direccion');
   $ciudad = $request->getParam('ciudad'); 
  
  $sql = "INSERT INTO usuarios (nombre, apellidos, telefono, email, direccion, ciudad) VALUES 
          (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombre', $nombre);
    $resultado->bindParam(':apellidos', $apellidos);
    $resultado->bindParam(':telefono', $telefono);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':direccion', $direccion);
    $resultado->bindParam(':ciudad', $ciudad);

    $resultado->execute();
    echo json_encode("Nuevo usuario guardado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 



// PUT Modificar usuario 
$app->put('/api/usuarios/modificar/{id}', function(Request $request, Response $response){
   $id_cliente = $request->getAttribute('id');
   $nombre = $request->getParam('nombre');
   $apellidos = $request->getParam('apellidos');
   $telefono = $request->getParam('telefono');
   $email = $request->getParam('email');
   $direccion = $request->getParam('direccion');
   $ciudad = $request->getParam('ciudad'); 
  
  $sql = "UPDATE usuarios SET
          nombre = :nombre,
          apellidos = :apellidos,
          telefono = :telefono,
          email = :email,
          direccion = :direccion,
          ciudad = :ciudad
        WHERE id = $id_cliente";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombre', $nombre);
    $resultado->bindParam(':apellidos', $apellidos);
    $resultado->bindParam(':telefono', $telefono);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':direccion', $direccion);
    $resultado->bindParam(':ciudad', $ciudad);

    $resultado->execute();
    echo json_encode("usuario modificado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// DELETE borar usuario 
$app->delete('/api/usuarios/delete/{id}', function(Request $request, Response $response){
   $id_cliente = $request->getAttribute('id');
   $sql = "DELETE FROM usuarios WHERE id = $id_cliente";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);
     $resultado->execute();

    if ($resultado->rowCount() > 0) {
      echo json_encode("usuario eliminado.");  
    }else {
      echo json_encode("No existe usuario con este ID.");
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 







