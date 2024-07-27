<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class TacOp extends \OFW\OFWObject
{
	public $tacopid = '';
	public $archetype = '';
	public $tacopseq = 0;
	public $title = '';
	public $description = '';

	function __construct()
	{
		$this->TableName = "TacOp";
		$this->Keys = ["tacopid"];
	}

	public static function GetTacOp($tacopid)
	{
		global $dbcon;

		//Get the requested Tac Op
		$t = TacOp::FromDB($tacopid);

		return $t;
	}
}
?>