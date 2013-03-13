<?
class Falesia {
	private $link_value;
	private $html;
	private $retriever;
	private $nome_falesia;
	private $settore;
	private $db;
	public function __construct($link_value, $retriever, $nome_falesia, $settore, $db) {	
		$this->nome_falesia = $nome_falesia;
		$this->settore = $settore;
		$this->link_value = $link_value;
		$this->retriever = $retriever;
		$this->html = $this->connect();
		$this->db = $db; 
		$this->extract_dati();
	}

	private function queryDb()
	{
		$query = "INSERT into vie (nome, grado, grado_proposto, ripetizioni, id_falesia) VALUES (\"".htmlspecialchars_decode($via->getNome())."\",'".$via->getGrado()."','".$via->getGradoProposto()."','"
                .$via->getRipetizioni()."','".$id_falesia."')";

                $result = $this->db->query($query);
	}

	private function extract_dati()
	{
		$id_falesia = $this->getIdFalesia();
		echo "nome falesia: ".$nome_falesia." id_falesia: ".$id_falesia."<br>";
		foreach($this->html->find('a') as $element)
		{
			if (strpos($element->href, "vie/"))
			{
				$via = new Via($element->href, $this->retriever);
				sleep(1);

			}
		}
		$this->html->clear(); 
		unset($this->html);
	}

	private function getIdFalesia()
	{
		$query = "SELECT id from falesia where settore='".$this->getSettore()."' AND nome='".$this->getNomeFalesia()."'";
		$result = $this->db->query($query);
		while($row = mysql_fetch_array($result))
  		{
  			return $row['id'];
  		}
	}

	private function getNomeFalesia()
	{
		return $this->nome_falesia;
	}
	private function getSettore()
	{
		return $this->settore;
	}

	private function constructLink($link)
	{
	        $url_vie = "http://www.climbook.com".$link."/vie";
        	return $url_vie;
	}

	private function connect() {
		$url = $this->constructLink($this->getLink());
		echo "URL: ".$url."<br>";
                $page = file_get_html($url);
                if ($page==false)
                {
                	return null;
                }

		return $page;

	}
	public function getLink()
	{
		return $this->link_value;
	}
}
?>
