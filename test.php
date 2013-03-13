<html>
<head><title>xmlrpc</title></head>
<body>
<?php
set_time_limit(0);
include_once 'Retriever.php';
include_once 'simple_html_dom.php';
include_once 'Via.php';
include_once 'DbManager.php';
include_once 'Falesia.php';


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
					//if( (strpos($element, "eremo-di-san-michele")) || (strpos($element, "eremo-di-san-leonardo")) )
					if( strpos($element, "Falesie") === false )
					{
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
						
						$falesia = new Falesia($element->href,$nome_falesia, $settore, $db);
						$falesia->connect();
						$falesia->extract_dati();
//						echo "nome: ".$nome_falesia." settore: ".$settore." id_falesia: ".$id_falesia."<br>";
					}
					
				}
			}
			$db->disconnect();
?>
</body>
</html>
