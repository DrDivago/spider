<?
class DbManager {
	private $nomehost = "localhost";
	private $nomeuser = "root";
	private $password = "pelicano";
	private $attiva = false;
	private $connessione;
	public function __construct() {
	}

	public function connect() {
		if ($this->attiva == false)
		{
			$connessione = mysql_connect($this->nomehost,$this->nomeuser,$this->password) or die('Could not connect: ' . mysql_error());
			mysql_set_charset("UTF8", $connessione);
			mysql_select_db("falesia", $connessione);
			$this->attiva = true;
		}
	}
	

	public function query($query) {
		$risultato = mysql_query($query)
    			or die("Query non valida: " . mysql_error());	
		return $risultato;
	}

}
?>
