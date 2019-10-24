
<?
class Catalog extends CSalePdf { 
    function LoadData($file) { 
        
        $lines=file($file); 
        $data=array(); 
        
        //echo "<pre>";
        //print_r($lines);
        //echo "</pre>";
        
        $countSection = 0;
        $countSubSection = 0;
        foreach($lines as $line) {
            $isSection = 0;
            $isSubSection = 0;
            echo strpos($line,"s1:")."<br />";
            if(strpos($line,"s1:")!== FALSE){
                $data[$countSection]["NAME"] =  substr($line, 3, 0);
                echo $line." = ".substr($line, 3, 0)."<br />";
                $isSection = 1;
            }else if(strpos($line,"s2:")!== FALSE){
                $data[$countSection][$countSubSection]["NAME"] =  substr($line, 3, 0);
                $isSubSection = 1;
            }else{
                $data[$countSection][$countSubSection]["PRODUCTS"][] = explode('####',chop($line));
            } 
            if($isSection == 1){
                $countSection++;
            }
            if($isSubSection == 1){
                $countSubSection++;
            }
        }
        return $data; 
    } 
}    
?>