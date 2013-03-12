<?
class Falesia {
	private $link_value;
	private $html;
	private $retriever;
	private $nome_falesia;
	private $settore;
	public function __construct($link_value, $retriever, $nome_falesia, $settore) {	
		$this->nome_falesia = $nome_falesia;
		$this->settore = $settore;
		$this->link_value = $link_value;
		$this->retriever = $retriever;
		$this->html = $this->connect();
		$this->extract_dati();
	}
	private function extract_dati()
	{
		$id_falesia = $this->getIdFalesia();
		foreach($this->html->find('a') as $element)
		{
			if (strpos($element->href, "vie/"))
			{
				$via = new Via($element->href, $this->retriever);
				$query = "INSERT into vie (nome, grado, grado_proposto, ripetizioni, id_falesia) VALUES (\"".htmlspecialchars_decode($via->getNome())."\",'".$via->getGrado()."','".$via->getGradoProposto()."','"
				.$via->getRipetizioni()."','".$id_falesia."')";

				$db = new DbManager();
				$db->connect();
				$result = $db->query($query);
			}
		}
	}

	private function getIdFalesia()
	{
		$db = new DbManager();
		$db->connect();
		$query = "SELECT id from falesia where settore='".$this->getSettore()."' AND nome='".$this->getNomeFalesia()."'";
		$result = $db->query($query);
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
                $page = $this->retriever->getHTMLPageFromURL($url);
                if ($page==false)
                {
                	return null;
                }

                $html =  str_get_html($page);
		return $html;

	}
/*
	private function extract_data()
	{
        	$nome_via = $via->getNome();
                $pos = strpos($nome_via, "avanzi");
                if ($pos !== false)
                {
                	$url = constructLink($via->getLink());
                        $page = $r->getHTMLPageFromURL($url);
                        if ($page==false)
                        {
                        	return null;
                        }

                        $html = str_get_html($page);
                        $p = strpos($html->plaintext, "Grado ufficiale");
                        $inizio = $p + 16;

                        $testo = $html->plaintext;
                        $pos = strpos($testo[$inizio+2], "+");
                        if ($pos !== false)
                        	$len = 3;
                        else
                       		$len = 2;

                                                                                echo "testo: ".substr($testo, $inizio, $len);
                                                                                $db = new DbManager();
                                                                                $db->connect();
                                                                                $db->insert_db($nome_via, $grado, $grado_proposto, $ripetizioni, $bellezza);
                                                                                $db->query();
                                                                        }


	}
*/

	public function getLink()
	{
		return $this->link_value;
	}
}
?>
