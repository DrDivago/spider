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
	

			foreach($html->find('a') as $element) 
			{
				#if (strpos($element, "falesie"))
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
										$query = "INSERT INTO via (nome, grado, grado_proposto, ripetizioni, bellezza) VALUES('".$via->getNome()."','".$via->getGrado()."','".$via->getGradoProposto()."',1,1)";
										echo "query: ".$query;

										$db = new DbManager();
										$db->connect();
										$db->query($query);
									}
								}
							}
						}
					}
				}
			}

?>
</body>
</html>
