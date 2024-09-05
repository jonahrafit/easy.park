<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require('Base_Controller.php');
class Parking extends CI_Controller {
	
    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url'); 
		$this->load->helper('assets');
		$this->load->model('Voiture_model' , 'voiture');
		$this->load->model('Parking_model' , 'parking');
		$this->load->model('Compte_model','compte'); 
		date_default_timezone_set('utc');
    }
	public function index()
	{
        $data['page'] = 'parking.php';
		$this->lasa($data);
	}
	public function lasa($data)
	{
        $daty = $this->input->post('daty');
        if($daty != null)
        {
            $data['daty'] = $daty;
        }
        $data['getnow'] = $this->parking->getNow();
        $data['now'] = $this->parking->datenow();
        $data['solde'] = $this->compte->getFiche();
        $data['solde'] = $data['solde']['solde'];
        $data['tarifs'] = $this->parking->getListeTarif();
        $data['places'] = $this->parking->getListePlace($daty);
		$this->load->view('template', $data);
	}
    public function nouveauplace()
    {
        $this->parking->nouveauplace();
        $this->index();
    }
    public function ajoutervoiture()
    {
		$idplace = $this->input->post('idplace');
		$immatriculation = $this->input->post('immatriculation');
		$tarif = $this->input->post('tarif');
		$datetimedebut = $this->input->post('datetimedebut');
        $retour = $this->parking->ajoutervoiture($idplace , $immatriculation , $tarif , $datetimedebut);
        
        if($retour['test'] == '1'){  
            $data['message'] = 'INSERTION Voiture OK! TARIF Payé , Imprimer votre ticket s\'il vous plaît'; 
            $data['ticket'] = $retour;
        }
        else if($retour['test'] == '2') {
            $data['error'] = 'Cet voiture ne peut pas entrer suite à une AMENDE NON PAYE , '.$retour['amende'].' Ar';
        }
        else if($retour['test'] == '3') {
            $data['error'] = 'Solde insuffisant , il manque '.$retour['manque'].' Ar pour ajouter cet voiture';
        }
        else {  
            $data['error'] = $retour;
        }
        $data['page'] = 'parking.php';
        $this->lasa($data); 
    }
    public function enlevervoiture()
    {
        $idplacevoiture = $this->input->post('idplacevoiture');
        $immatriculation = $this->input->post('immatriculation');
        $datetimesortie = $this->input->post('datetimesortie');
        $amende = $this->input->post('amende');
        if($this->parking->enlevervoiture($idplacevoiture, $datetimesortie ,$immatriculation, $amende) == '2')
        {
            $data['error'] = 'Enlever ce voiture c\'est impossible , car assez d`\'argent pour l\'amende!';
        }
        else{
            $data['message'] = 'Une voiture '.$immatriculation.' quitte le parking !';
            if($amende != null){
                $data['message'] = $data['message'].' , avec une Amende de '.$amende;
            }
        }
        $data['page'] = 'parking.php';
        $this->lasa($data);
    }
    public function modifiervoiture()
    {
        $idplace_voiture = $this->input->post('idplace_voiture');
		// $immatriculation = $this->input->post('immatriculation');
		// $tarif = $this->input->post('tarif');
		$datetimedebut = $this->input->post('datetimedebut');
        $this->parking->modifierplacevoiture($idplace_voiture , $datetimedebut);
        $data['page'] = 'parking.php';
        $data['message'] = 'Modification reussi !!! ';
        $this->lasa($data);
    }
    public function pdf_ticket()
    {
        $data = array(
            'immatriculation' =>  $this->input->post('immatriculation'),
            'heure' => $this->input->post('heure'),
            'minute' => $this->input->post('minute'),
            'cout' => $this->input->post('cout'),
            'cout_final' => $this->input->post('cout_final'),
            'datetimedebut' => $this->input->post('datetimedebut'),
            'remise' => $this->input->post('remise') ,
            'deadline' => $this->input->post('deadline')
        );
        $this->load->library('pdf');
		$this->pdf->load_view('pdf/ticket', $data);
        $this->pdf->render();
        ob_end_clean();
        $this->pdf->stream('Ticket'.$data['immatriculation']."-".$data['datetimedebut'].".pdf");
    }
    public function gestionplace()
    {
        $idplace = $this->input->post('idplace');
        $statut_actuel = $this->input->post('statut_actuel');
        $this->parking->modifiestatutplace($idplace, $statut_actuel);
        $data['page'] = 'parking.php';
        $data['message'] = 'Modification etat de place Reussi !!! ';
        $this->lasa($data);
    }
    
}