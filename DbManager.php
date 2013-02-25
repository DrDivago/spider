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
			$this->connessione = mysql_connect($this->nomehost,$this->nomeuser,$this->password);	
			mysql_select_db("falesie");
		}
	}

	public function query($query) {
		$risultato = mysql_query($query)
    			or die("Query non valida: " . mysql_error());	
	}
}
?>
