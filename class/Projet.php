<?php
	class Projet {
		private $id;
		private $nom;
		private $image;
		private $utilisateurs;
		private $sousFonctionnalites;

		public function __construct()
		{ 
		    $args = func_get_args(); 
		    $i = func_num_args(); 
		    if (method_exists($this,$f='__construct'.$i)) { 
		        call_user_func_array(array($this,$f),$args); 
		    } 
		} 

		public function __construct3($id, $nom, $image){
			global $DAO;
			$this->id = $id;
			$this->nom = $nom;
			$this->image = $image;
			$this->utilisateurs = $DAO->getUtilisateursByProjectId($id);
			$this->sousFonctionnalites = $DAO->getFonctionnalitesByProjetId($id);
		}

		public function getId(){
			return $this->id;
		}

		public function getNom(){
			return $this->nom;
		}

		public function getImage(){
			return $this->image;
		}

		public function getSousFonctionnalites(){
			return $this->sousFonctionnalites;
		}

		
	}
?>