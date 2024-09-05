<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Compte_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('Parking_model' , 'parking');
		date_default_timezone_set('utc');
    }

    public function validateLogin($login, $mdp)
    {
        $sql = "select * , case when id in (select idcompte from admin) then 'admin' else 'user' end as fonction from compte
        where login='".$this->db->escape_str($login)."' and mdp = sha1('".$this->db->escape_str($mdp)."')";
        // var_dump($sql);
        $qa = $this->db->query($sql);
        $compte = array();
        if ($qa -> num_rows() == 1)
        {
            $row = $qa->row();
			$compte = array('id' => $row-> id, 'nom' => $row->nom , 'login' => $row->login, 'fonction' => $row->fonction);
            return $compte;
        } else {
            return null;
        }
        $this->db->close();
    }
    
    public function nouveaucompte($nom , $prenom , $login , $mdp)
    {
        $sql = "INSERT INTO eval_easy_park.compte ( id, nom, prenom, login, mdp) VALUES ( null, '%s', '%s', '%s', sha1('%s'))";
        $sql = sprintf($sql , $nom , $prenom , $login , $mdp);
        $this->db->query($sql);
    }
    public function insertToPortfeuille($montant)
    {
		$id = $_SESSION['compte']['id'];
        $sql =  "INSERT INTO eval_easy_park.portefeuille( id, idcompte, isvalider, montant , date_recharge) VALUES ( null, '%s', 'NON', '%s' ,'".$this->parking->getNow()."') ";
        $sql = sprintf($sql , $id , $montant);
        // var_dump($sql);
        $this->db->query($sql);
    }
    public function getListePortefeuille()
    {
        $sql = "select p.*, c.nom, c.prenom from portefeuille p join compte c on p.idcompte=c.id where p.isvalider='NON' order by p.date_recharge desc";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		return $data;
    }
    public function getFiche()
    {
        $id = $_SESSION['compte']['id'];
        $sql =  "select * from view_solde where id = '".$id."'";
        $query = $this->db->query($sql);
		$data = $query->row_array();
        return $data;
    }
    public function validationRecharge($id)
    {
        $sql = "update portefeuille set isvalider ='OUI' where id ='".$id."'";
        // var_dump($sql);
        $this->db->query($sql);
    }
}