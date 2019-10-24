#!/bin/sh

FILE_DIR="/home/webmaster/web/proconsim.ru/public_html/cron/";
DATE=`date +%d-%m-%Y' '%k:%M:%S`;
PHP="/usr/bin/php -q";
update(){
    ERR=0;
#    echo ZERO;
    if [ -f ${FILE_DIR}step3.php ]; then
        echo -en "################################################################################" >> ${FILE_DIR}log.log;
        echo -e "START STEP3.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step3.php "$1" "$2" >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step3.txt ]; then
               echo "ERRORS in step3.php FILE step4.php IS NOT STARTED" >> ${FILE_DIR}log.log;
               ERR=1;
        fi
        DATE=`date +%d-%m-%Y' '%k:%M:%S`;
        echo  "END STEP3.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step3.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
    if [[ -f ${FILE_DIR}step4.php && $ERR -eq 0 ]]; then
        echo  $DATE >> ${FILE_DIR}log.log;
        echo  "START STEP4.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step4.php "$1" "$2" >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step4.txt ]; then
            echo "ERRORS in step4.php FILE step5.php IS NOT STARTED" >> ${FILE_DIR}log.log;
            ERR=1;
        fi
        echo  "END STEP4.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step4.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
    if [[ -f ${FILE_DIR}step4_4.php && $ERR -eq 0 ]]; then
        echo  $DATE >> ${FILE_DIR}log.log;
        echo  "START STEP4_4.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step4_4.php "$1" "$2" >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step4_4.txt ]; then
            echo "ERRORS in step4_4.php FILE step5_5.php IS NOT STARTED" >> ${FILE_DIR}log.log;
            ERR=1;
        fi
        echo  "END STEP4_4.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step4_4.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
    if [[ -f ${FILE_DIR}step5_5.php && $ERR -eq 0 ]]; then
        echo  $DATE >> ${FILE_DIR}log.log;
        echo  "START STEP5_5.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step5_5.php "$1" "$2" >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step5_5.txt ]; then
            echo "ERRORS in step5_5.php FILE step5.php IS NOT STARTED" >> ${FILE_DIR}log.log;
            ERR=1;
        fi
        echo  "END STEP5_5.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step5_5.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
    if [[ -f ${FILE_DIR}step5.php && $ERR -eq 0 ]]; then
        echo  $DATE >> ${FILE_DIR}log.log;
        echo  "START STEP5.PHP: " $DATE >> ${FILE_DIR}log.log;
        $PHP ${FILE_DIR}step5.php "$1" "$2" >> ${FILE_DIR}php_log.log;
        if [ -f ${FILE_DIR}report_step5.txt ]; then
            echo "ERRORS in step5.php FILE step6.php IS NOT STARTED" >> ${FILE_DIR}log.log;
            ERR=1;
        fi
        echo  "END STEP5.PHP: " $DATE >> ${FILE_DIR}log.log;
    else
        echo "NOT FIND FILE step5.php" >> ${FILE_DIR}log.log;
        ERR=1;
    fi
}

case "$1" in
          'update')
         update $2 $3
#         echo 'UPDATE';
     ;;
               'clear')
     echo Clear;
     ;;
    *)
    echo "usage $0 update|clear"
esac
