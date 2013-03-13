<html>
<head><title>xmlrpc</title></head>
<body>
<h1>Getstatename demo</h1>
<h2>Send a U.S. state number to the server and get back the state name</h2>
<h3>The code demonstrates usage of the php_xmlrpc_encode function</h3>
<?php
set_time_limit(600);
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
				echo "plaintext: ".$e->plaintext."<br>";
				$p = strpos($e->plaintext, "Falesia");
				if ( $p === false)
				{
				$pos = strrpos($e->plaintext, ' ', -4);
				$num_vie = substr($e->plaintext, $pos);
				$len_num_vie = strlen($num_vie);
				$text = substr($e->plaintext, 0, strlen($e->plaintext)-$len_num_vie);
				$v = explode(":", $text);
				if ( count($v) > 1)
				{
					$settore = $v[1];
				}
				else
				{
					$settore = "";
				}
				echo "nome: ".$v[0]." settore: ".html_entity_decode($settore, ENT_QUOTES)." num_vie: ".$num_vie."<br>";

	                                $db = new DbManager();
        	                        $db->connect();
					$query = "INSERT INTO falesia (nome, regione, stato, settore, num_vie, coordinate) VALUES (\"".trim(html_entity_decode($v[0], ENT_QUOTES))."\",'lazio'".",'italia'".",\"".trim(html_entity_decode($settore, ENT_QUOTES))."\",".$num_vie.",'0.0')";
					echo "query: ".$query."<br>";
                                	$db->query($query);
				}
			}	
*/
			$db = new DbManager();
			$db->connect();
			foreach($html->find('a') as $element)
			{
				if (strpos($element, "falesie"))
				{
//					if (strpos($element, "eremo-di-san-michele"))
//					{
						$el = explode(":", $element->plaintext);
						if ( count($el) == 2)
						{
							$nome_falesia = $el[0];
							$settore = $el[1];
						}
						else 
						{
							$nome_falesia = $el[0];
							$settore = "";
						}
//						$via = new Via($element->href, $r);
						
						$falesia = new Falesia($element->href, $r, $nome_falesia, $settore, $db);
//						echo "nome: ".$via->getNome()." settore: ".$via->getSettore()."<br>";
//					}
					
				}
			}
			$db->disconnect();
?>
</body>
</html>
