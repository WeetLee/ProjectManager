<?php
	class Utilisateur {
		private $id;
		private $nom;
		private $image;
		private $username;
		private $motDePasse;

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
	}
?>