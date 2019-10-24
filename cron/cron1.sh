#!/bin/sh

FILE_DIR="/home/webmaster/web/proconsim.ru/public_html/cron/";
DATE=`date +%d-%m-%Y' '%k:%M:%S`;
PHP="/usr/bin/php -q";
update(){
    ERR=0;
#    echo ZERO;
    if [ -f ${FILE_DIR}step1.php ]; then
#    echo "ONE => " $DATE;
            echo -en "################################################################################" >> ${FILE_DIR}log.log;
            echo -e "START STEP1.PHP: " $DATE >> ${FILE_DIR}log.log;
            $PHP ${FILE_DIR}step1.php >> ${FILE_DIR}php_log.log;
            if [ -f ${FILE_DIR}report_step1.txt ]; then
               echo "ERRORS in step1.php FILE step2.php IS NOT STARTED" >> ${FILE_DIR}log.log;
               ERR=1;
            fi
            DATE=`date +%d-%m-%Y' '%k:%M:%S`;
            echo  "END STEP1.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
       echo "NOT FIND FILE step1.php" >> ${FILE_DIR}log.log;
       ERR=1;
    fi
    if [[ -f ${FILE_DIR}step2.php && $ERR -eq 0 ]]; then
        echo  $DATE >> ${FILE_DIR}log.log;
        echo  "START STEP2.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step2.php >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step2.txt ]; then
            echo "ERRORS in step2.php FILE step3.php IS NOT STARTED" >> ${FILE_DIR}log.log;
            ERR=1;
        fi
        echo  "END STEP2.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step2.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
}

case "$1" in
          'update')
         update
#         echo 'UPDATE';
     ;;
               'clear')
     echo Clear;
     ;;
    *)
    echo "usage $0 update|clear"
esac
