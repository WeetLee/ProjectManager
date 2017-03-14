<?php
	class DAO {
		private static $_instance = null;
		
		private function __construct()
		{ 
		} 

		public static function getInstance() {
			if(is_null(self::$_instance)) {
				self::$_instance = new DAO();  
			}
		 
			return self::$_instance;
		}

		public function getAllProjets() {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Projet');
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Projet($ligne['id'],$ligne['nom'],$ligne['image']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getProjetById($id) {
			global $bdd;
			$query=$bdd->prepare('SELECT * FROM Projet where id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Projet($ligne['id'],$ligne['nom'],$ligne['image']);
			return $item;
		}

		public function getAllUtilisateurs() {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Utilisateur');
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Utilisateur($ligne['id'],$ligne['nom'],$ligne['image']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getUtilisateursByProjectId($id) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM utilisateurProjet where idProjet=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = $this->getUtilisateurById($ligne['idUtilisateur']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getUtilisateurById($id) {
			global $bdd;
			$query=$bdd->prepare('SELECT * FROM Utilisateur where id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Utilisateur($ligne['id'],$ligne['nom'],$ligne['image']);
			return $item;
		}
		public function getAllTests() {}
		public function getTestsByFonctionnaliteId($idParent) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Test WHERE idFonctionnalite=:id');
			$query->bindValue(':id',$idParent, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Test($ligne['id'],$ligne['nom'],$ligne['statut'],$ligne['dateDerniereExecution']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getTestById($id) {
			global $bdd;
			$query=$bdd->prepare('SELECT * FROM Test WHERE id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Test($ligne['id'],$ligne['nom'],$ligne['statut'],$ligne['dateDerniereExecution']);
			return $item;
		}
		public function getAllTaches() {}
		public function getTachesByFonctionnaliteId($idParent) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Tache WHERE idFonctionnalite=:id ORDER BY type');
			$query->bindValue(':id',$idParent, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Tache($ligne['id'],$ligne['nom'],$ligne['statut'],$ligne['dureePrevisionnelle'], $ligne['affectation'], $ligne["type"]);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getTacheById($id) {
			global $bdd;
			$query=$bdd->prepare('SELECT * FROM Tache WHERE id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Tache($ligne['id'],$ligne['nom'],$ligne['statut'],$ligne['dureePrevisionnelle'], $ligne['affectation'], $ligne["type"]);
			return $item;
		}
		public function getAllFonctionnalites() {}
		public function getFonctionnalitesByProjetId($idProjet) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite WHERE idProjet=:id AND idFonctionnaliteParent is NULL');
			$query->bindValue(':id',$idProjet, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Fonctionnalite($ligne['id'],$ligne['type'],$ligne['nom'],$ligne['statut'], $ligne['affectation'], $ligne['priorite'], $ligne['idFonctionnaliteParent'], $ligne['commentaire']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getFonctionnalitesByFonctionnaliteId($idParent) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite WHERE idFonctionnaliteParent=:idParent');
			$query->bindValue(':idParent',$idParent, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Fonctionnalite($ligne['id'],$ligne['type'],$ligne['nom'],$ligne['statut'], $ligne['affectation'], $ligne['priorite'], $ligne['idFonctionnaliteParent'], $ligne['commentaire']);
				array_push($liste, $item);	
			}
			return $liste;
		}

		public function getFonctionnaliteById($id){
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite WHERE id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Fonctionnalite($ligne['id'],$ligne['type'],$ligne['nom'],$ligne['statut'], $ligne['affectation'], $ligne['priorite'], $ligne['idFonctionnaliteParent'], $ligne['commentaire']);
			return $item;
		}

		public function getAllFonctionnaliteByProject($idProjet) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite WHERE idProjet=:idProjet ORDER BY priorite');
			$query->bindValue(":idProjet",$idProjet, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Fonctionnalite($ligne['id'],$ligne['type'],$ligne['nom'],$ligne['statut'], $ligne['affectation'], $ligne['priorite'], $ligne['idFonctionnaliteParent'], $ligne['commentaire']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		
		public function getSimpleFonctionnaliteById($id) {
			global $bdd;
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite WHERE id=:id');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			$item = new Fonctionnalite($ligne['id'],$ligne['nom']);
			return $item;
		}

		public function getSimpleFonctionnaliteParent($id){
			global $bdd;
			$query=$bdd->prepare('SELECT id, nom FROM Fonctionnalite WHERE id IN (SELECT idFonctionnaliteParent FROM Fonctionnalite WHERE id=:id)');
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			if(isset($ligne['id'])){
				$item = new Fonctionnalite($ligne['id'],$ligne['nom']);
				return $item;
			}else
				return null;
		}
	
		public function saveFonctionnalite($fonctionnalite, $idFonctionnaliteParent = 0, $idProjet = 0){
			global $bdd;
			if($this->getSimpleFonctionnaliteById($fonctionnalite->getId())->getId() !== null){
				$query=$bdd->prepare("UPDATE Fonctionnalite SET type=:type, nom=:nom, statut=:statut, priorite=:priorite, affectation=:affectation, commentaire=:commentaire WHERE id=:id");
				$query->bindValue(":type", $fonctionnalite->getType(), PDO::PARAM_INT);
				$query->bindValue(":nom", $fonctionnalite->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $fonctionnalite->getStatut(), PDO::PARAM_INT);
				$query->bindValue(":affectation", $fonctionnalite->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":priorite", $fonctionnalite->getPriorite(), PDO::PARAM_INT);
				$query->bindValue(":commentaire", $fonctionnalite->getCommentaire(), PDO::PARAM_STR);
				$query->bindValue(":id", $fonctionnalite->getId(), PDO::PARAM_INT);
				$query->execute();
			}else{
				$query=$bdd->prepare("INSERT INTO Fonctionnalite(type, nom, statut, affectation, priorite, idFonctionnaliteParent, idProjet, commentaire) VALUES 
																(:type, :nom, :statut, :affectation, :priorite, :idFonctionnaliteParent, :idProjet, :commentaire)");
				$query->bindValue(":type", $fonctionnalite->getType(), PDO::PARAM_INT);
				$query->bindValue(":nom", $fonctionnalite->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $fonctionnalite->getStatut(), PDO::PARAM_INT);
				$query->bindValue(":affectation", $fonctionnalite->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":priorite", $fonctionnalite->getPriorite(), PDO::PARAM_INT);
				$query->bindValue(":idFonctionnaliteParent", $idFonctionnaliteParent, PDO::PARAM_INT);
				$query->bindValue(":idProjet", $idProjet, PDO::PARAM_INT);
				$query->bindValue(":commentaire", $fonctionnalite->getCommentaire(), PDO::PARAM_STR);
				$query->execute();
			}
		}
		
		public function saveProjet($projet){
			global $bdd;
			if($this->getProjetById($projet->getId())->getId() !== null){
				$query=$bdd->prepare("UPDATE projet SET nom=:nom, image=:image WHERE id=:id");
				$query->bindValue(":nom", $projet->getNom(), PDO::PARAM_STR);
				$query->bindValue(":image", $projet->getImage(), PDO::PARAM_STR);
				$query->bindValue(":id", $projet->getId(), PDO::PARAM_INT);
				$query->execute();
			}else{
				$query=$bdd->prepare("INSERT INTO projet (nom, image) VALUES (:nom,:image)");
				$query->bindValue(":nom", $projet->getNom(), PDO::PARAM_STR);
				$query->bindValue(":image", $projet->getImage(), PDO::PARAM_STR);
				$query->execute();
			}
		}

		public function updateStatutFonctionnalite($idFonctionnalite){
			global $bdd;
			$query=$bdd->prepare("SELECT id FROM Tache WHERE type='Bug' AND idFonctionnalite=:idFonctionnalite AND statut != 'Terminé'");
			$query->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
			$query->execute();
			$ligne = $query->fetch();
			if(isset($ligne['id'])){
				$query2=$bdd->prepare("UPDATE Fonctionnalite SET type = 'Bug' WHERE id=:idFonctionnalite");
				$query2->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
				$query2->execute();
			}else{
				$query2=$bdd->prepare("UPDATE Fonctionnalite SET type = 'Evolution' WHERE id=:idFonctionnalite");
				$query2->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
				$query2->execute();
			}
		}

		public function saveTache($tache, $idFonctionnalite = 0){
			global $bdd;
			if($this->getTacheById($tache->getId())->getId() !== null){
				$query=$bdd->prepare("UPDATE Tache SET nom=:nom, statut=:statut, dureePrevisionnelle=:dureePrevisionnelle, affectation=:affectation, type=:type WHERE id=:id");
				$query->bindValue(":nom", $tache->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $tache->getStatut(), PDO::PARAM_STR);
				$query->bindValue(":dureePrevisionnelle", $tache->getDureePrevisionnelle(), PDO::PARAM_STR);
				$query->bindValue(":affectation", $tache->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":id", $tache->getId(), PDO::PARAM_INT);
				$query->bindValue(":type", $tache->getType(), PDO::PARAM_STR);
				$query->execute();
			}else{
				$query=$bdd->prepare("INSERT INTO Tache(nom, statut, dureePrevisionnelle, affectation, idFonctionnalite, type) VALUES (:nom, :statut, :dureePrevisionnelle, :affectation, :idFonctionnalite, :type)");
				$query->bindValue(":nom", $tache->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $tache->getStatut(), PDO::PARAM_STR);
				$query->bindValue(":dureePrevisionnelle", $tache->getDureePrevisionnelle(), PDO::PARAM_STR);
				$query->bindValue(":affectation", $tache->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
				$query->bindValue(":type", $tache->getType(), PDO::PARAM_STR);
				$query->execute();
			}
			$this->updateStatutFonctionnalite($idFonctionnalite);
		}		
		
		public function saveTest($test, $idFonctionnalite = 0){
			global $bdd;
			if($this->getTestById($test->getId())->getId() !== null){
				$query=$bdd->prepare("UPDATE test SET nom=:nom, statut=:statut, dateDerniereExecution=:dateDerniereExecution WHERE id=:id");
				$query->bindValue(":nom", $test->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $test->getStatut(), PDO::PARAM_STR);
				$query->bindValue(":dateDerniereExecution", $test->getDateExec(), PDO::PARAM_STR);
				$query->bindValue(":id", $test->getId(), PDO::PARAM_INT);
				$query->execute();
			}else{
				$query=$bdd->prepare("INSERT INTO test(nom, statut, dateDerniereExecution, idFonctionnalite) VALUES (:nom, :statut, :dateDerniereExecution, :idFonctionnalite)");
				$query->bindValue(":nom", $test->getNom(), PDO::PARAM_STR);
				$query->bindValue(":statut", $test->getStatut(), PDO::PARAM_STR);
				$query->bindValue(":dateDerniereExecution", $test->getDateExec(), PDO::PARAM_STR);
				$query->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
				$query->execute();
			}
		}
	}
?>