<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class RosterTacOp extends \OFW\OFWObject
{
    public $rosterid = "";
    public $userid = "";
    public $tacopid = "";
    public $revealed = 0;
    public $VP1 = 0;
    public $VP2 = 0;

    function __construct()
    {
        $this->TableName = "RosterTacOp";
        $this->Keys = ["userid", "rosterid", "tacopid"];
        $this->skipfields = [];
    }
}
?>