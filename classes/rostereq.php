<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class RosterEq extends \OFW\OFWObject
{
    public $userid = "";
    public $rosterid = "";
    public $eqfactionid = "";
    public $eqkillteamid = "";
    public $eqid = "";

    function __construct()
    {
        $this->TableName = "RosterEquipment";
        $this->Keys = ["userid", "rosterid", "eqfactionid", "eqkillteamid", "eqid"];
        $this->skipfields = [];
    }
}
