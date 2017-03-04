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

		public function __construct0(){
			global $DAO;
		}
		public function __construct4($id, $nom, $statut, $dateExec){
			global $DAO;
			$this->id = $id;
			$this->nom = $nom;
			$this->statut = $statut;
			$this->dateExec = $dateExec;
		}
	}
?>