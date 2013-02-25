<?
class Via {
	private $nome;	
	private $grado;
	private $grado_proposto;
	private $ripetizioni;
	private $regione;
	private $link_value;
	private $html;
	private $retriever;
	public function __construct($html, $retriever) {	
		$this->link_value = $html->href;
		$this->retriever = $retriever;
		$this->html = $this->connect();
		$this->extract_dati();
	}
	private function extract_dati()
	{
                $testo = $this->html->find("dd");
		$this->nome = $testo[0]->plaintext;
		$this->settore = $testo[1]->plaintext;
		$this->regione = $testo[2]->plaintext;
		$this->grado = $testo[3]->plaintext;
		$this->grado_proposto = $testo[4]->plaintext;
		$this->ripetizioni = $testo[5]->plaintext;
	}

	private function constructLink($link)
	{
	        $url_vie = "http://www.climbook.com".$link;
        	return $url_vie;
	}

	private function connect() {
		$url = constructLink($this->getLink());
                $page = $this->retriever->getHTMLPageFromURL($url);
                if ($page==false)
                {
                	return null;
                }

                return str_get_html($page);

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

	public function getGrado()
	{
		return $this->grado;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getGradoProposto()
	{
		return $this->grado_proposto;
	}

	public function getRipetizioni()
	{
		return $this->ripetizioni;
	}
	public function getLink()
	{
		return $this->link_value;
	}
	public function getSettore()
	{
		return $this->settore;
	}
}
?>
