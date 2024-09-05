<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parking_model extends CI_Model
{
    public function __construct()
    {
		date_default_timezone_set('utc');
		$this->load->model('Compte_model', 'compte');
    }

	public function getListePlaceParking()
	{
		$sql = "select * from place";
		$query = $this->db->query($sql);
		$data = array();
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		return $data;
		var_dump($data);
	}
    public function getNow()
    {
        $sql = "select daty from datenow";
        $req = $this->db->query($sql);
        $row = $req->row_array();
        $this->db->close();
		if($row['daty'] != null)
		{
			return $row['daty'];
		}
		return $this->datenow();
    }
    public function Changegetnow($daty)
	{
		if($daty == null){
			$this->db->query(" delete from datenow");
			return $this->datenow();
		}
		else{
			$req = $this->db->query("select count(*) as nb from datenow");
			$row = $req->row_array();
			$this->db->close();
			$sql = "update eval_easy_park.datenow set daty = '%s' ";
			if($row['nb'] == 0 ) {
				$sql = "INSERT INTO eval_easy_park.datenow (daty) VALUES ('%s' )";
			}
			$sql = sprintf($sql , $daty);
			$this->db->query($sql);
			return $daty;
		}
	}
    public function datenow()
    {
        $sql = "select now() as now";
        $req = $this->db->query($sql);
        $row = $req->row_array();
        $this->db->close();
		return $row['now'];
    }

	public function getListePlace($daty)
	{
		$sql = "call view_etat_place('".$this->getNow()."')";
		if($daty != null)
		{
			$sql = "call view_etat_place('".$daty."')";
		}
		// var_dump($sql);
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		$this->db->close();
		return $data;
	}
    public function nouveauplace()
    {
        $sql = "INSERT INTO eval_easy_park.place( id, idparking) VALUES ( null, 1)";
        $this->db->query($sql);
    }
    public function SimpleStat($daty)
    {
		$retour = array();
		$lp = $this->getListePlace($daty);
		$retour['total'] = count($lp);
		$retour['occupe'] = 0 ;
		$retour['libre'] = 0 ;
		$retour['eninfraction'] = 0 ;
		$retour['indisponible'] = 0 ;
		for($i=0;$i<count($lp);$i++)
		{
			if($lp[$i]->statut == 'OCCUPE'){ $retour['occupe'] = $retour['occupe'] + 1; }
			else if($lp[$i]->statut == 'INFRACT'){ $retour['eninfraction'] = $retour['eninfraction'] + 1; }
			else if($lp[$i]->statut == 'INDISP'){ $retour['indisponible'] = $retour['indisponible'] + 1; }
			else {	$retour['libre'] = $retour['libre'] + 1; }
		}
		// var_dump($retour);
		return $retour;
    }
	public function getListeTarif()
	{
		$query = $this->db->query("SELECT * FROM tarif ORDER BY concat(heure, ':', minute)");
		foreach ($query->result() as $row) 
			$data[] = $row;
		return $data;
	}
	public function newvoiture($immatriculation)
	{
		$idretour = null;
		$sql = "select * from voiture where immatriculation like '%".$this->db->escape_str($immatriculation)."%'";
        $qa = $this->db->query($sql);
        if ($qa -> num_rows() == 0)
        {
			$sql = "INSERT INTO eval_easy_park.voiture( id, immatriculation) VALUES (null,'%s')";
			$sql = sprintf($sql , $immatriculation);
			$this->db->query($sql);
			$sql = "select max(id) as idvoiture from voiture";
			$req = $this->db->query($sql);
			$row = $req->row_array();
			$idretour = $row['idvoiture'];
		}  
		else{
			$row = $qa->row_array();
			$idretour = $row['id'];
		}
		return $idretour;
		$this->db->close();
	}
	public function getTarifById($idtarif)
	{
		$sql = "select * from tarif where id = '%s'";
		$sql = sprintf($sql , $idtarif);
		$req = $this->db->query($sql);
		$row = $req->row_array();
		return $row;
	}
	public function checkifaoamparking($immatriculation, $daty)
	{
		// var_dump($immatriculation);
		$data = $this->getListePlace($daty);
		for($i=0;$i<count($data);$i++)
		{
			if($immatriculation == $data[$i]->immatriculation)
			{
				return true;
			}
		}
		return false;
	}
	public function isEfaAoamParking($immatriculation)
	{
		$sql = "select * from view_place where immatriculation like '%".$this->db->escape_str($immatriculation)."%'";
		$qa = $this->db->query($sql);
		if ($qa -> num_rows() == 0)
		{
			return false;
		} else {
			return true;
		}    
	}
	public function ajoutervoiture($idplace , $immatriculation , $tarif , $datetimedebut)
	{
		// if(!$this->isEfaAoamParking($immatriculation))
		if(!$this->checkifaoamparking($immatriculation, $datetimedebut))
		{
			$amende = $this->ckeckamende($immatriculation);
			$retour = array();
			if($amende['immatriculation'] == NULL)
			{
				$solde = $this->compte->getFiche();
				$tarif = $this->getTarifById($tarif);
				$vola = ($solde['solde'] - $tarif['cout']);
				if($vola < 0){
					$retour['manque'] = abs($vola);
					$retour['test'] = '3';
				}
				else{
					$idvoiture = $this->newvoiture($immatriculation);
					$this->payement($_SESSION['compte']['id'] , $tarif['cout'] , $immatriculation, $datetimedebut);

					$sql = "INSERT INTO eval_easy_park.place_voiture (id, idplace, idvoiture, datetimedebut, heure_tarif, minute_tarif, cout , statut ) 
						VALUES ( null, '%s', '%s', '%s', '%s', '%s', '%s' , 'IN')";
					$sql = sprintf($sql ,$idplace , $idvoiture, $datetimedebut, $tarif['heure'], $tarif['minute'], $tarif['cout'] );
					$this->db->query($sql);
					$retour['tarif'] = $tarif;
					$retour['immatriculation'] = $immatriculation;
					$retour['datetimedebut'] = $datetimedebut;
					$retour['test'] = '1';
				}
			}
			else {
				$retour['amende'] = $amende['amende'];
				$retour['immatriculation'] = $immatriculation;
				$retour['test'] = '2';
			}
			return $retour;
		}
		else{
			return 'Cet vehicule est déja dans le parking! ';
		}
	}
	public function enlevervoiture($idplacevoiture, $datetimesortie ,$immatriculation, $amende)
	{
		$solde = $this->compte->getFiche();
		$solde = $solde['solde'];
		if($amende != null){
			if($solde < $amende)
			{
				return '2';
			}
			else {
				$sql = "insert into amende(immatriculation , amende , statut_payer , daty) values ( '%s','%s','OUI', '%s')";
				$sql = sprintf($sql , $immatriculation , $amende , $datetimesortie);
				$this->db->query($sql);
				$sql = "UPDATE eval_easy_park.place_voiture SET statut = 'OUT' , datetimesortie = '%s' where id = '%s'";
				$sql = sprintf($sql , $datetimesortie , $idplacevoiture);
				$this->db->query($sql);
			}
		}
		else{
			$sql = "UPDATE eval_easy_park.place_voiture SET statut = 'OUT' , datetimesortie = '%s' where id = '%s'";
			$sql = sprintf($sql , $datetimesortie , $idplacevoiture);
			$this->db->query($sql);
			// var_dump('ATO ZANY SADY TSIS AMENDE NO AMPY VOLA');
			$this->db->close();
		}
	}
	public function modificationtarif($id, $heure, $minute , $cout)
	{
		$sql = "update tarif set heure ='%s' , minute='%s' , cout ='%s' where id ='%s'";
		$sql = sprintf($sql, $heure, $minute , $cout , $id);
		$this->db->query($sql);
	}
	public function nouveautarif($heure, $minute , $cout)
	{
		$sql = "insert into tarif(heure, minute,cout) values ('%s','%s','%s')";
		$sql = sprintf($sql, $heure, $minute , $cout );
		if($heure == 0 && $minute == 0){
			return 'Pourquoi cette tarif là? 0 heure et 0 minute !!!';
		}
		else{
			$this->db->query($sql);
			return '1';
		}
	}
	public function supprimertarif($id)
	{
		$qa = $this->db->query("select count(*) as total from tarif");
        $nb = $qa->row_array();
		$nb = $nb['total'] ;
		if($nb <= 1)
		{
			return false;
		}
		else{
			$sql = "delete from tarif where id ='%s'";
			$sql = sprintf($sql, $id);
			$this->db->query($sql);
			return true;
		}
	}
	public function payement($idcompte , $montant , $immatriculation, $daty)
	{
		$sql ="insert into payement(idcompte , montant , immatriculation, daty) values ('%s','%s','%s','%s')";
		$sql = sprintf($sql , $idcompte , $montant , $immatriculation, $daty);
		$this->db->query($sql);
	}
	public function modifierplacevoiture($idplace_voiture , $datetimedebut)
	{
		$sql ="UPDATE place_voiture SET datetimedebut='%s' WHERE id = '%s'";
		$sql = sprintf($sql , $datetimedebut , $idplace_voiture );
		$this->db->query($sql);
	}
	public function getMouvementParking($limit, $start)
	{
		$query = "select * from mouvement_parking where 1<2 ";
		if($_SESSION['filtre'] != null)
		{
			$filtre = $_SESSION['filtre'];
			if($filtre['parking'] == null){	$filtre['parking'] = 'Tous'; }
			if($filtre['parking'] != 'Tous'){ 
				$query = $query." and idplace ='".$filtre['parking']."'";
			}
			if($filtre['datymin'] != null)
			{
				$query = $query." and datetimedebut >='".$filtre['datymin']."'";
			}
			if($filtre['datymax'] != null)
			{
				$query = $query." and datetimedebut <='".$filtre['datymax']."'";
			}
		}
		// var_dump($filtre);
		// $tarif = $this->getTarifById($tarif);
		$query = $query." order by idplace_voiture desc limit ".$limit." offset ".$start;
		// var_dump($query);
		$query = $this->db->query($query);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		return $data;

	}
	public function getTotal()
	{
		return $this->db->count_all("mouvement_parking");
	}

	public function ckeckamende($immatriculation)
	{
		$sql ="select immatriculation, sum(amende) as amende from amende where immatriculation = '%s' and statut_payer ='NON'";
		$sql = sprintf($sql , $immatriculation);
		$qa = $this->db->query($sql);
        return $qa->row_array();
	}
	public function modifiestatutplace($idplace, $statut_actuel)
	{
		$ok = 'KO';
		if($statut_actuel == 'INDISP')
		{
			$ok = 'OK';
		}
		$sql ="UPDATE place SET statut='%s' WHERE id = '%s'";
		$sql = sprintf($sql ,$ok,  $idplace);
		// var_dump($sql);
		$this->db->query($sql);
	}
	public function getSituationdeParking()
	{
		$sql = "call view_situation_praking('".$this->getNow()."')";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		$this->db->close();
		return $data;
	}
}