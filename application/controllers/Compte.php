<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compte extends CI_Controller {
	
    public function __construct()
    {
        parent::__construct();   
		$this->load->helper('url'); 
		$this->load->helper('assets');
		$this->load->model('Parking_model' , 'parking');
		$this->load->model('Compte_model','compte');     
		date_default_timezone_set('utc');
    }
	public function index()
	{
		$this->login();
	}
	public function lasa($data)
	{
		$this->load->view('template', $data);
	}
	public function validate()
	{
		$login = $this->input->post('login');
		$mdp = $this->input->post('mdp');
		$data = array();
		$compte = $this->compte->validateLogin($login, $mdp);
		var_dump($compte);
		if($compte != null) {
			$this->session->set_userdata("compte" , $compte);
			redirect('Parking');
		}
		else
		{
			$data['message'] = " Erreur ! login ou mot de passe incorrect ";
			$this->load->view('login', $data);
		}
	}
	public function logout()
	{
		session_destroy();
		$data = array();
		$data['message'] = " Deconnécté ";
		$this->load->view('login' , $data);
	}	
	public function login()
	{
		$this->load->view('login.php');
	}
	public function inscription()
	{
		$this->load->view('inscription.php');
	}
	
	public function do_inscription()
	{
		$data = array();
		$nom = $this->input->post('nom');
		$prenom = $this->input->post('prenom');
		$login = $this->input->post('login');
		$mdp = $this->input->post('mdp');
		$mdp_retap = $this->input->post('mdp_retap');
		$values = array(
			'nom' => $nom,
			'prenom' => $prenom,
			'login' => $login,
			'mdp' => $mdp,
			'mdp_retap' => $mdp_retap
		);
		if(strcmp($mdp,$mdp_retap) == 0) {
			$data['message'] = "Inscription réussi !!!!";
			$this->compte->nouveaucompte($nom , $prenom , $login , $mdp);
		}
		else { 
			$data['values'] = $values;
			$data['error'] = "Erreur!!! ";
		}
		$this->load->view('inscription' , $data);
	}
	public function fiche()
	{
		// var_dump($_SESSION['compte']);
		$data['page'] = 'ficheCompte.php';
		$data['soldes'] = $this->compte->getFiche();
		$this->lasa($data);
	}
	public function ajoutDansPortfeuille()
	{
		$montant = $this->input->post('montant');
		$this->compte->insertToPortfeuille($montant);
		$data = array();
		$data['soldes'] = $this->compte->getFiche();
		$data['page'] = 'ficheCompte.php';
		$data['message'] = 'Ajout reussi !! attendez la validation de l\'administrateur';
		$this->lasa($data);
	}
}