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
				$item = new Tache($ligne['id'],$ligne['nom'],$ligne['statut'],$ligne['dateDerniereExecution']);
				array_push($liste, $item);	
			}
			return $liste;
		}
		public function getTestById($id) {}
		public function getAllTaches() {}
		public function getTachesByFonctionnaliteId($idParent) {
			global $bdd;
			$liste = array();
			$query=$bdd->prepare('SELECT * FROM Tache WHERE idFonctionnalite=:id');
			$query->bindValue(':id',$idParent, PDO::PARAM_INT);
			$query->execute();
			while($ligne = $query->fetch()){
				$item = new Tache($ligne['id'],$ligne['nom'],$ligne['avancement'],$ligne['dureePrevisionnelle'], $ligne['affectation']);
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
			$item = new Tache($ligne['id'],$ligne['nom'],$ligne['avancement'],$ligne['dureePrevisionnelle'], $ligne['affectation']);
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
			$query=$bdd->prepare('SELECT * FROM Fonctionnalite ORDER BY priorite');
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
	
		public function saveFonctionnalite($fonctionnalite){
			global $bdd;
			$query=$bdd->prepare("UPDATE Fonctionnalite SET type=:type, nom=:nom, statut=:statut, priorite=:priorite, commentaire=:commentaire WHERE id=:id");
			$query->bindValue(":type", $fonctionnalite->getType(), PDO::PARAM_INT);
			$query->bindValue(":nom", $fonctionnalite->getNom(), PDO::PARAM_STR);
			$query->bindValue(":statut", $fonctionnalite->getStatut(), PDO::PARAM_INT);
			$query->bindValue(":priorite", $fonctionnalite->getPriorite(), PDO::PARAM_INT);
			$query->bindValue(":commentaire", $fonctionnalite->getCommentaire(), PDO::PARAM_STR);
			$query->bindValue(":id", $fonctionnalite->getId(), PDO::PARAM_INT);
			$query->execute();
		}

		public function saveTache($tache, $idFonctionnalite = 0){
			global $bdd;
			if($this->getTacheById($tache->getId())->getId() !== null){
				$query=$bdd->prepare("UPDATE Tache SET nom=:nom, avancement=:avancement, dureePrevisionnelle=:dureePrevisionnelle, affectation=:affectation WHERE id=:id");
				$query->bindValue(":nom", $tache->getNom(), PDO::PARAM_STR);
				$query->bindValue(":avancement", $tache->getAvancement(), PDO::PARAM_STR);
				$query->bindValue(":dureePrevisionnelle", $tache->getDureePrevisionnelle(), PDO::PARAM_STR);
				$query->bindValue(":affectation", $tache->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":id", $tache->getId(), PDO::PARAM_INT);
				$query->execute();
			}else{
				$query=$bdd->prepare("INSERT INTO Tache(nom, avancement, dureePrevisionnelle, affectation, idFonctionnalite) VALUES (:nom, :avancement, :dureePrevisionnelle, :affectation, :idFonctionnalite)");
				$query->bindValue(":nom", $tache->getNom(), PDO::PARAM_STR);
				$query->bindValue(":avancement", $tache->getAvancement(), PDO::PARAM_STR);
				$query->bindValue(":dureePrevisionnelle", $tache->getDureePrevisionnelle(), PDO::PARAM_STR);
				$query->bindValue(":affectation", $tache->getAffectationId(), PDO::PARAM_INT);
				$query->bindValue(":idFonctionnalite", $idFonctionnalite, PDO::PARAM_INT);
				$query->execute();
			}
		}		
	}
?>