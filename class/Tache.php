<?php
	class Tache {
		private $id;
		private $nom;
		private $avancement;
		private $dureePrevisionnelle;
		private $affectation;

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
		public function __construct4($nom, $avancement, $dureePrevisionnelle, $affectation){
			global $DAO;
			$this->nom = $nom;
			$this->avancement = $avancement;
			$this->dureePrevisionnelle = $dureePrevisionnelle;
			if($affectation != "")
				$this->affectation = $DAO->getUtilisateurById($affectation);
			else
				$this->affectation = $affectation;
		}

		public function __construct5($id, $nom, $avancement, $dureePrevisionnelle, $affectation){
			global $DAO;
			$this->id = $id;
			$this->nom = $nom;
			$this->avancement = $avancement;
			$this->dureePrevisionnelle = $dureePrevisionnelle;
			$this->affectation = $DAO->getUtilisateurById($affectation);
		}

		public function getId(){
			return $this->id;
		}

		public function getNom(){
			return $this->nom;
		}

		public function getAvancement(){
			return $this->avancement;
		}
		public function getDureePrevisionnelle(){
			return $this->dureePrevisionnelle;
		}

		public function getAffectation(){
			return $this->affectation;
		}
		public function getAffectationId(){
			if($this->affectation == "")
				return "";
			else
				return $this->affectation->getId();
		}
		public function setAvancement($statut){
			$this->avancement = $statut;
		}

		public function setDuree($duree){
			$this->dureePrevisionnelle = $duree;
		}

		public function getCompletionByStatut(){
			$statut = $this->getAvancement();
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