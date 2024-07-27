<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class Equipment extends \OFW\OFWObject
{
	public $factionid = "";
	public $killteamid = "";
	public $eqid = "";
	public $eqname = "";
	public $eqdescription = "";
	public $eqpts = "";
	public $eqtype = "";
	public $eqvar1 = "";
	public $eqvar2 = "";
	public $eqvar3 = "";
	public $eqvar4 = "";
	public $eqcategory = "";

	function __construct()
	{
		$this->TableName = "equipmentid";
		$this->Keys = ["killteamid", "eqid"];
	}

	public static function GetEquipment($factionid, $killteamid, $eqid)
	{
		global $dbcon;

		//Get the requested Equipment
		$e = Ploy::FromDB($factionid, $killteamid, $eqid);

		return $e;
	}
}
