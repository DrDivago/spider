<html>
<head><title>xmlrpc</title></head>
<body>
<h1>Getstatename demo</h1>
<h2>Send a U.S. state number to the server and get back the state name</h2>
<h3>The code demonstrates usage of the php_xmlrpc_encode function</h3>
<?php

include_once 'Retriever.php';
include_once 'simple_html_dom.php';
include_once 'Via.php';
include_once 'DbManager.php';
include_once 'Falesia.php';

function checkValid($vie)
{
	$ret = null;
        $pieces = explode("/", $vie->href);
        if (count($pieces) > 2)
        {
        	$nome_via = strstr($pieces[2], "-");
                $ret = trim(str_replace("-", " ", $nome_via));
        }
        return $ret;
}

function constructLink($link)
{
	$url_vie = "http://www.climbook.com".$link;
	return $url_vie;
}

			$r = new Retriever();
			$url = "http://www.climbook.com/regioni/1-ita-lazio/falesie";
                        $page = $r->getHTMLPageFromURL($url);
                        if ($page==false)
                        {
                                return null;
                        }

                        $html = str_get_html($page);
/*
			foreach($html->find('tr') as $e)
			{
				$v = explode("\n", $e->plaintext);
				$nome_settore = $v[1];
				$num_vie = $v[2];
				$s = explode(":", $nome_settore);
				$pos = strpos($s[0], "Falesia");
				if ( $pos === false)
				{
//				echo "nome: ".$s[0]." numero vie: ".$num_vie." settore: ".$s[1]."<br>";

	                                $db = new DbManager();
        	                        $db->connect();
					$query = "INSERT INTO falesia (nome, regione, stato, settore, num_vie, coordinate) VALUES ('".$s[0]."','lazio'".",'italia'".",'".$s[1]."',".$num_vie.",'0.0')";
					echo "query: ".$query."<br>";
                                	$db->query($query);
				}
			}	
*/	

			foreach($html->find('a') as $element)
			{
				if (strpos($element, "falesie"))
				{
					if (strpos($element, "bassiano-fascia-superiore"))
					{
						echo "element: ".$element->plaintext."<br>";
						$el = explode(":", $element->plaintext);
						$nome_falesia = $el[0];
						$settore = $el[1];
//						$via = new Via($element->href, $r);
						$falesia = new Falesia($element->href, $r, $nome_falesia, $settore);
//						echo "nome: ".$via->getNome()." settore: ".$via->getSettore()."<br>";
					}
				}
			}

/*
			foreach($html->find('a') as $element) 
			{
				if (strpos($element, "falesie"))
				{
				}
				if (strpos($element, "bassiano-fascia-superiore"))
				{	
					$fal = $element->href;
					$fal = $fal."/vie";
					$url_vie = "http://www.climbook.com/".$fal;
					$page = $r->getHTMLPageFromURL($url_vie);
					if ( $page !== false)
					{
						$html_vie = str_get_html($page);
						foreach($html_vie->find('a') as $vie)
						{	
							if (strpos($vie->href, "vie"))
							{
								$nome_via = checkValid($vie);
								if ( $nome_via !== null)
								{
									$pos = strpos($nome_via, "avanzi");
									if ($pos !== false)
									{
										$via = new Via($vie, $r);
										echo "rip: ".$via->getRipetizioni();
									}
								}
							}
						}
					}
				}
			}
*/

?>
</body>
</html>
