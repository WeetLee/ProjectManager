<?php
	class Tache {
		private $id;
		private $nom;
		private $statut;
		private $dureePrevisionnelle;
		private $affectation;
		private $type;

		public function __construct()
		{ 
		    $args = func_get_args(); 
		    $i = func_num_args(); 
		    if (method_exists($this,$f='__construct'.$i)) { 
		        call_user_func_array(array($this,$f),$args); 
		    } 
		} 

		public function __construct0(){
			global $DAO;
		}
		public function __construct5($nom, $statut, $dureePrevisionnelle, $affectation, $type){
			global $DAO;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->dureePrevisionnelle = $dureePrevisionnelle;
			if($affectation != "")
				$this->affectation = $DAO->getUtilisateurById($affectation);
			else
				$this->affectation = $affectation;
			$this->type = $type;
		}

		public function __construct6($id, $nom, $statut, $dureePrevisionnelle, $affectation, $type){
			global $DAO;
			$this->id = $id;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->dureePrevisionnelle = $dureePrevisionnelle;
			$this->affectation = $DAO->getUtilisateurById($affectation);
			$this->type = $type;
		}

		public function getId(){
			return $this->id;
		}

		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}

		public function getStatut(){
			return $this->statut;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function getDureePrevisionnelle(){
			return $this->dureePrevisionnelle;
		}

		public function getAffectation(){
			return $this->affectation;
		}
		public function getAffectationId(){
			if($this->affectation == "")
				return NULL;
			else
				return $this->affectation->getId();
		}
		public function setAffectation($id){
			global $DAO;
			$this->affectation = $DAO->getUtilisateurById($id);
		}
		public function setStatut($statut){
			$this->statut = $statut;
		}

		public function setDuree($duree){
			$this->dureePrevisionnelle = $duree;
		}

		public function getCompletionByStatut(){
			$statut = $this->getstatut();
			$pourcentage = 0;
			switch($statut){
				case "A analyser":{
					$pourcentage = 0;
					break;
				}
				case "A faire":{
					$pourcentage = 10;
					break;
				}
				case "En cours":{
					$pourcentage = 30;
					break;
				}
				case "A tester":{
					$pourcentage = 70;
					break;
				}
				case "Terminé":{
					$pourcentage = 100;
					break;
				}
				default:{
					$pourcentage = 0;
					break;
				}
			}
			return $pourcentage;
		}
	}
?>