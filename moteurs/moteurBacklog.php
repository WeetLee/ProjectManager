<?php
  if(isset($_POST['filtre'])){
    $filtres = $_POST['filtre']; 
  }else
    $filtres = array();
	
  $idProjet = $_POST['idProjet'];

  define('__ROOT__',dirname(dirname(__FILE__)));
  require_once(__ROOT__.'/utils/links.php');
  $mesFonctionnalites = $DAO->getAllFonctionnaliteByProject($idProjet);

  function filterArray($mesFonctionnalites,$filtres){
    $newListe = array();
    foreach($mesFonctionnalites as $fonctionnalite){
      $flag = 0;
      foreach($filtres as $filtre){
        if($fonctionnalite->getAffectation() == $filtre){
          $flag += 1;
        }
        if($fonctionnalite->getType() == $filtre){
          $flag += 1;
        }
        if($fonctionnalite->getStatut() == $filtre){
          $flag += 1;
        }
      }
      if($flag == 3){
        array_push($newListe,$fonctionnalite);
      }
    }
    return $newListe;
  }
  $liste = filterArray($mesFonctionnalites,$filtres);
 
  $listePrioritaire = array();
  $listeImportante = array();
  $listeMoyen = array();
  $listeMineur = array();
  foreach($liste as $fonctionnalite){
    if($fonctionnalite->getPriorite() == 1){
      array_push($listePrioritaire,$fonctionnalite);
    }else if($fonctionnalite->getPriorite() == 2){
      array_push($listeImportante,$fonctionnalite);
    }else if($fonctionnalite->getPriorite() == 3){
      array_push($listeMoyen, $fonctionnalite);
    }else{
      array_push($listeMineur,$fonctionnalite);
    }
  }
  $liste = array($listePrioritaire,$listeImportante, $listeMoyen,$listeMineur);
?>
<div class="container">
  <div id="theGrid" class="main">
    <section class="grid">
        <table style='width:100%;table-layout: fixed;'>
          <tr>
            <td><h1>Prioritaire</h1><hr></td>
            <td><h1>Important</h1><hr></td>
            <td><h1>Moyen</h1><hr></td>
            <td><h1>Mineur</h1><hr></td>
          <tr>
          <?php
            $index=1;
            foreach($liste as $listeFonctionnalite){
                ?>
                <td id='sortable_<?php echo $index; ?>' style='vertical-align:top;' class='connectedSortable'>
                  <?php
                      foreach($listeFonctionnalite as $fonctionnalite){
                    ?>
                    <div id="<?php echo $fonctionnalite->getId(); ?>">
                      <a class="grid__item" href="#">
                        <h2 class="title" onclick="javascript:afficherFonctionnalite(<?php echo $fonctionnalite->getId(); ?>)"><?php echo $fonctionnalite->getNom(); ?> <img class="meta__avatar__type"src="../img/type/<?php echo $fonctionnalite->getType();?>.png"/></h2>
                        <div class="loader"></div>
                        <span class="category"><?php echo $fonctionnalite->getParentNom();?></span>
                        <div class="meta">
                          <img class="meta__avatar" src="../img/collab/<?php echo $fonctionnalite->getAffectation();?>.png" alt="<?php echo $fonctionnalite->getAffectation();?>.png" />
                        </div>
                      </a><br/>
                    </div>
                    <?php
                      }
                    ?>
                <?php
              echo "</td>";
              $index++;
            }
          echo "</tr>";
        echo "</table>";
      ?>
    </section>
  </div>
</div>