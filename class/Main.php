<?php
	class Main {
		private $projets;
		private $utilisateurs;

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
			$this->projets = $DAO->getAllProjets();
			$this->utilisateurs = $DAO->getAllUtilisateurs();
		}
	}
?>