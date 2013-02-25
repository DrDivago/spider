<?php
class Retriever {
    private static $AGENT = 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1';

        function __construct() {
                //Nothing to do         
        }


        public function getHTMLPageFromURL($url) {
                // create curl resource
                //echo "<br>Prima di curl_init:".date("l F d, Y, h:i:s"); 

        $output = "";

                $ch = curl_init();

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, Retriever::$AGENT);
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string 
        $output = curl_exec($ch);

        // close curl resource to free up system resources 
        curl_close($ch);

        unset($ch);

                //$output = file_get_contents($url); 


        return $output;
        }
        //OK

}
?>
