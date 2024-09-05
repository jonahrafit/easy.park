<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Voiture_model extends CI_Model
{
    public function __construct()
    {
		date_default_timezone_set('utc');
    }
    
	public function getListeVoiture()
	{
		$sql = "select * from voiture";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		return $data;
	}
	public function getListeVoitureAmendée()
	{
		$sql = "select * from voiture";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) 
		{
			$data[] = $row;
		}
		return $data;
	}
}