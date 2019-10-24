<?



$ts_start = time();



$cur_sec = 0;



while(true) {

   

   $seconds = time() - $ts_start;

   

   if($seconds%20==0 && $cur_sec!=$seconds) {

      echo $seconds."<br />";

      $cur_sec = $seconds;

   }

   

   if($seconds>=700)

      break;

   

}