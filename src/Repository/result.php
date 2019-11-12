<!-- methode 3 -->
<?php
include_once 'env.php';
if(isset($_GET['motclef'])){
  $motclef = $_GET['motclef'];
  $q = array('motclef' => $motclef. '%'); // si le mot cherché existe on le rajoute dans un tab
  $sql = 'SELECT title FROM objet WHERE title like :motclef';
  $req = $env->prepare($sql);
  $req->execute($q);
  $count = $req->rowCount($sql);

  if($count == 1){
    while ($result= $req->fetch(PDO::FETCH_OBJ)){
      echo "titre:".$result->title;
    }
    }else{
      echo "l'objet n'existe pas il faut le creer";
    }

  }


 ?>
