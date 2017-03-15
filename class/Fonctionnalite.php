<?php
	class Fonctionnalite {
		private $id;
		private $fonctionnaliteParent;
		private $type;
		private $nom;
		private $statut;
		private $affectation;
		private $priorite;
		private $taches;
		private $tests;
		private $sousFonctionnalites;
		private $completion;
		private $commentaire;

		public function __construct()
		{ 
		    $args = func_get_args(); 
		    $i = func_num_args(); 
		    if (method_exists($this,$f='__construct'.$i)) { 
		        call_user_func_array(array($this,$f),$args); 
		    } 
		} 

		public function __construct2($id, $nom){
			$this->id = $id;
			$this->nom = $nom;
		}

		public function __construct7($type, $nom, $statut, $affectation, $priorite, $fonctionnaliteParent, $commentaire){
			global $DAO;
			$this->type = $type;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->affectation = $DAO->getUtilisateurById($affectation);
			$this->priorite = $priorite;
			$this->taches = $DAO->getTachesByFonctionnaliteId($id);
			$this->tests = $DAO->getTestsByFonctionnaliteId($id);
			$this->sousFonctionnalites = $DAO->getFonctionnalitesByFonctionnaliteId($id);
			$this->fonctionnaliteParent = $DAO->getSimpleFonctionnaliteById($fonctionnaliteParent);
			$this->commentaire = $commentaire;
			$this->completion = $this->calculCompletion();
		}
		
		public function __construct8($id, $type, $nom, $statut, $affectation, $priorite, $fonctionnaliteParent, $commentaire){
			global $DAO;
			$this->id = $id;
			$this->type = $type;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->affectation = $DAO->getUtilisateurById($affectation);
			$this->priorite = $priorite;
			$this->taches = $DAO->getTachesByFonctionnaliteId($id);
			$this->tests = $DAO->getTestsByFonctionnaliteId($id);
			$this->sousFonctionnalites = $DAO->getFonctionnalitesByFonctionnaliteId($id);
			$this->fonctionnaliteParent = $DAO->getSimpleFonctionnaliteById($fonctionnaliteParent);
			$this->commentaire = $commentaire;
			$this->completion = $this->calculCompletion();
		}

		public function getId(){
			return $this->id;
		}

		public function getType(){
			return $this->type;
		}

		public function getNom(){
			return $this->nom;
		}

		public function getParentNom(){
			return $this->fonctionnaliteParent->getNom();
		}

		public function getParentId(){
			return $this->fonctionnaliteParent->getId();
		}

		public function getStatut(){
			return $this->statut;
		}

		public function getAffectation(){
			return $this->affectation->getNom();
		}
		
		public function getAffectationId(){
			return $this->affectation->getId();
		}

		public function getPriorite(){
			return $this->priorite;
		}

		public function setPriorite($priorite){
			$this->priorite = $priorite;
		}

		public function getSousFonctionnalites(){
			return $this->sousFonctionnalites;
		}

		public function getCommentaire(){
			return $this->commentaire;
		}

		public function getTaches(){
			return $this->taches;
		}
		
		public function getTests(){
			return $this->tests;
		}

		public function getNbTachesTerminees(){
			$taches = $this->getTaches();
			$count = 0;
			foreach($taches as $uneTache){
				if($uneTache->getAvancement() == "Terminé")
					$count++;
			}
			return $count;
		}

		public function getCompletion(){
			return $this->completion;
		}

		public function getCompletionTaches(){
			$taches = $this->getTaches();
			$count = 0;
			$sum = 0;
			foreach($taches as $uneTache){
				$dureeTache = $uneTache->getDureePrevisionnelle();
				$count+=($uneTache->getCompletionByStatut())*$dureeTache;
				$sum+=(1*$dureeTache);
			}
			if($sum != 0)
				$completion = $count / $sum;
			else{
				$completion = "100";
			}
			return $completion;
		}

		public function getCompletionTests(){
			$tests = $this->getTests();
			$count = 0;
			$sum = 0;
			foreach($tests as $unTest){
				$count+=$unTest->getCompletionByStatut();
				$sum+=1;
			}
			if($sum != 0)
				$completion = $count / $sum;
			else{
				$completion = "100";
			}
			return $completion;
		}
		
		public function getFilAriane(){
			global $DAO;
			$id = $this->getId();
			$liste = [[$this->getId(),$this->getNom()]];
			if($this->fonctionnaliteParent->getId() != null){
				array_unshift($liste,[$this->fonctionnaliteParent->getId(),$this->fonctionnaliteParent->getNom()]);
			}
			$idParent = $this->fonctionnaliteParent->getId();
			while($idParent != null){
				$newParent = $DAO->getSimpleFonctionnaliteParent($idParent);
				if($newParent != null){
					array_unshift($liste, [$newParent->getId(),$newParent->getNom()]);
					$idParent = $newParent->getId();
				}else{
					$idParent = null;
				}				
			}
			return $liste;
		}

		public function calculCompletion(){
			$sousFonctionnalites = $this->getSousFonctionnalites();
			foreach($sousFonctionnalites as $enfant) {
				$enfant->calculCompletion();
			}
			$count = 0;
			$sum = 0;
			foreach($sousFonctionnalites as $enfant) {
				$count++;
				$sum += $enfant->getCompletion();
			}
			$sum += $this->getCompletionTaches();//Taches completion
			$count++;
			$sum += $this->getCompletionTests();//Taches completion
			$count++;
			/*$sum += $this->getCompletionByStatut();
			$count++;*/
			if($sum != 0)
				$completion = round($sum / $count);
			else{
				$completion = 0;
			}
			return $completion;
		}

		public function getCompletionByStatut(){
			$statut = $this->getStatut();
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