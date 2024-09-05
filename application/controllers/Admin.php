<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Base_Controller.php');
class Admin extends Base_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Parking_model' , 'parking');    
        $this->load->model('Compte_model' , 'compte');
    }
    public function Changegetnow()
    {
        $getnow = $this->input->post('getnow');
        var_dump($getnow);
        $data = array();
        if($_SESSION['compte']['fonction'] == 'admin'){
            $data['message'] = 'Changement de getnow reussi!!!';
            $data['getnow'] = $this->parking->Changegetnow($getnow);
        }
		$this->lasa($data);
    }
    public function lasa($data)
    {
        $this->load->view('template', $data);
    }
	public function index()
	{
        $data = array();
        $data['page'] = 'dashboard.php';        
        $daty = $this->input->post('daty');
        if($daty != null)
        {
            $data['daty'] = $daty;
        }
        $data['tarifs'] = $this->parking->getListeTarif();
        $data['simplestat'] = $this->parking->SimpleStat($daty);
        // $data['places'] = $this->parking->getListePlaceParking();
        // var_dump($data['places']);
		$this->lasa($data);
	}
	public function tarif()
	{
        $data = array();
		$this->pageTarif($data);
	}
    public function pageTarif($data)
    {
        $data['page'] = 'tarif.php';
        $data['tarifs'] = $this->parking->getListeTarif();
		$this->lasa($data);
    }
    public function portefeuille()
    {
        $data = array();
        $data['page'] = 'portefeuille.php';
        $data['portefeuilles'] = $this->compte->getListePortefeuille();
		$this->lasa($data);
    }
    public function validationRecharge()
    {
        $data = array();
        $data['page'] = 'portefeuille.php';
        $data['message'] = 'Validation reussi!!! ';
		$id = $this->input->post('id');
		$this->compte->validationRecharge($id);
        $data['portefeuilles'] = $this->compte->getListePortefeuille();
		$this->lasa($data);
    }
    public function modificationtarif()
    {
        $id = $this->input->post('id');
        $heure = $this->input->post('heure');
        $minute = $this->input->post('minute');
        $cout = $this->input->post('cout');
        $this->parking->modificationtarif($id, $heure, $minute , $cout);
        $data['message'] = 'Modification Reussi !!!';
        $this->pageTarif($data);
    }
    public function nouveautarif()
    {
        $heure = $this->input->post('heure');
        $minute = $this->input->post('minute');
        $cout = $this->input->post('cout');
        if($this->parking->nouveautarif($heure, $minute , $cout) != '1'){
            $data['error'] = $this->parking->nouveautarif($heure, $minute , $cout);
        }
        else {
            $data['message'] = 'Ajout de nouveau tarif Reussi !!!';
        }
        $this->pageTarif($data);
    }
    public function supprimertarif()
    {
        $id = $this->input->post('id');
        if($this->parking->supprimertarif($id))
        {
            $data['message'] = 'Cet tarif a été supprimé !!!!! ';  
        }
        else{
            $data['error'] = 'Il faut ajouter un autre tarif avant de supprimer ça !!!!! ';  
        }
        $this->pageTarif($data);
    }
    public function SituationParking()
    {
        $data = array();
        $data['page'] = 'stituationdeparking.php';
        $data['stats'] = $this->parking->getSituationdeParking();
        $data['reference'] = $this->parking->getNow();
		$this->lasa($data);   
    }
    public function MouvementParking()
    {
        $data = array();
		$limit_per_page = 5;
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
		$total_records = $this->parking->getTotal();
        
        $filtre = array(
            'parking' => $this->input->post('parking'),
            'tarif' => $this->input->post('tarif'),
            'datymin' => $this->input->post('datymin'),
            'datymax' => $this->input->post('datymax')
        );
        $this->session->set_userdata("filtre" , $filtre);
        if ($total_records > 0)
		{
            $data['listemouvement'] = $this->parking->getMouvementParking($limit_per_page, $page*$limit_per_page);
            // var_dump($data['listemouvement']);
			$config['base_url'] = site_url().'Admin/MouvementParking/';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;
			
			$config['num_links'] = 4; // isan'ny gh droite
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			
			$config['first_link'] = '&laquo'.'&laquo';
			$config['last_link'] = '&raquo'.'&raquo';
			$config['first_tag_open'] = '<li class="page-item">';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);
			
			$data["links"] = $this->pagination->create_links();
            // var_dump($data['links']);
		}
        
        $data['tarifs'] = $this->parking->getListeTarif();
        $data['places'] = $this->parking->getListePlaceParking();

		$data['numpage'] = $page;
		$data['total'] = $total_records;
        $data['page'] = 'MouvementParking.php';
		$this->lasa($data);
    }
}