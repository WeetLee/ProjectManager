<?php
	class Test {
		private $id;
		private $nom;
		private $statut;
		private $dateExec;


		public function __construct()
		{ 
		    $args = func_get_args(); 
		    $i = func_num_args(); 
		    if (method_exists($this,$f='__construct'.$i)) { 
		        call_user_func_array(array($this,$f),$args); 
		    } 
		} 

		public function __construct3($nom, $statut, $dateExec){
			$this->nom = $nom;
			$this->statut = $statut;
			$this->dateExec = $dateExec;
		}
		public function __construct4($id, $nom, $statut, $dateExec){
			$this->id = $id;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->dateExec = $dateExec;
		}
		
		public function getId(){
			return $this->id;
		}

		public function getNom(){
			return $this->nom;
		}
		
		public function getStatut(){
			return $this->statut;
		}
		
		public function getDateExec(){
			return $this->dateExec;
		}
		
		public function setNom($nom){
			$this->nom = $nom;
		}
		
		public function setStatut($statut){
			$this->statut = $statut;
		}
		
		public function setDateExec($date){
			$this->dateExec = $date;
		}
		
		public function getCompletionByStatut(){
			$statut = $this->getstatut();
			$pourcentage = 0;
			switch($statut){
				case "KO":{
					$pourcentage = 0;
					break;
				}
				case "OK":{
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