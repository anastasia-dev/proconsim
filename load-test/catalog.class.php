
<?
class Catalog extends CSalePdf { 
    function LoadData($file) {        
        
        $lines=file($file); 
        $data=array();         
       
        $countSection = 0;
        $countSubSection = 0;
        foreach($lines as $line) {                      
                    
            if(strpos($line,"s1:")!== FALSE){
                $countSection++;
                $section = str_replace("\n","",$line);
                $data[$countSection]["NAME"] =  str_replace("s1:","",$section);                
                
            } else if(strpos($line,"s2:")!== FALSE){
                $countSubSection++;
                $subSection = str_replace("\n","",$line);
                $data[$countSection]["SUB"][$countSubSection]["NAME"] =  str_replace("s2:","",$subSection);
                
            }else{
                $data[$countSection]["SUB"][$countSubSection]["PRODUCTS"][] = explode('####',chop($line));
                $isProduct=1;
            } 
            
        }
        return $data; 
    }   
   
    
   
}    
?>