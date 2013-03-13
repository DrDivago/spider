<?
class Falesia {
	private $link_value;
	private $html;
	private $nome_falesia;
	private $settore;
	private $db;
	public function __construct($link_value, $nome_falesia, $settore, $db) {	
		$this->nome_falesia = $nome_falesia;
		$this->settore = $settore;
		$this->link_value = $link_value;
		$this->db = $db; 
	}

	private function queryDb($nome, $grado, $grado_proposto, $ripetizioni, $id_falesia)
	{
		
		$query = "INSERT into vie (nome, grado, grado_proposto, ripetizioni, id_falesia) VALUES (\"".addslashes(html_entity_decode(trim($nome), ENT_QUOTES ))."\",'".$grado."','".$grado_proposto."','"
                .$ripetizioni."','".$id_falesia."')";
		
               $result = $this->db->query($query);
	}

	public function extract_dati()
	{
		$list_vie = array();
		$id_falesia = $this->getIdFalesia();
		echo "nome falesia: ".$this->nome_falesia." id_falesia: ".$id_falesia."<br>";
		foreach($this->html->find('a') as $element)
		{
			if (strpos($element->href, "vie/"))
			{
				$via = new Via($element->href);
				$via->connect();
				sleep(2);
				$via->extract_dati();
				$list_vie[] = $via;
			}
		}


		foreach($list_vie as $v)
		{
			$this->queryDb($v->getNome(), $v->getGrado(), $v->getGradoProposto(), $v->getRipetizioni(), $id_falesia);
			$v->clear();
		}
		$this->html->clear(); 
		unset($this->html);
		unset($list_vie);
	}

	public function getIdFalesia()
	{
		$query = "SELECT id from falesia where settore=\"".html_entity_decode(trim($this->getSettore()), ENT_QUOTES )."\" AND nome=\"".html_entity_decode(trim($this->getNomeFalesia()) )."\"";
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

	public function constructLink($link)
	{
	        $url_vie = "http://www.climbook.com".$link."/vie";
        	return $url_vie;
	}

	public function connect() {
		$url = $this->constructLink($this->getLink());
		echo "URL: ".$url."<br>";
                $this->html = file_get_html($url);
	}
	public function getLink()
	{
		return $this->link_value;
	}
}
?>
