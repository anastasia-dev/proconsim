<?php
$mtime = microtime();  //Считываем текущее время
$mtime = explode(" ",$mtime); //Разделяем секунды и миллисекунды
// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

phpinfo();

$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$totaltime = ($mtime - $tstart);//Вычисляем разницу
// Выводим не экран
printf ("Страница сгенерирована за %f секунд !", $totaltime);
?>
