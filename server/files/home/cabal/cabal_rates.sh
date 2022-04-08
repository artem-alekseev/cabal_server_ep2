#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_rates.sh script must be run as root." 1>&2
   exit 1
fi

case "$1" in

  static)
    if [ -f /etc/cron.d/floating_rates ]; then
      echo -n "Stopping floating rates... "
      rm -f /etc/cron.d/floating_rates
      echo "Done."
    fi
      
    echo -n "Enter EXP rate multiplier, e.g. 5 for 5x [1] : "
    read exp_rate
    if [ -z $exp_rate ]; then
      exp_rate=1
    fi
    echo -n "Enter Skill EXP rate multiplier [1] : "
    read sexp_rate
    if [ -z $sexp_rate ]; then
      sexp_rate=1
    fi
    echo -n "Enter Craft EXP rate multiplier [1] : "
    read cexp_rate
    if [ -z $cexp_rate ]; then
      cexp_rate=1
    fi
    echo -n "Enter drop rate multiplier (over 5 is bad) [1] : "
    read drop_rate
    if [ -z $drop_rate ]; then
      drop_rate=1
    fi
    echo -n "Enter Alz rate multiplier [1] : "
    read alz_rate
    if [ -z $alz_rate ]; then
      alz_rate=1
    fi
    echo -n "Enter Alz bomb rate multiplier [1] : "
    read alzb_rate
    if [ -z $alzb_rate ]; then
      alzb_rate=1
    fi
    echo -n "Enter number of items per drop [1] : "
    read drop_amount
    if [ -z $drop_amount ]; then
      drop_amount=1
    fi
    let new_exp_rate=$exp_rate*100
    let new_sexp_rate=$sexp_rate*100
    let new_cexp_rate=$cexp_rate*100
    let new_drop_rate=$drop_rate*100
    let new_alz_rate=$alz_rate*100
    let new_alzb_rate=$alzb_rate*100
    sed /etc/cabal/templates/Const.cfg \
    -e "s/u00/$new_exp_rate/g" \
    -e "s/v00/$new_sexp_rate/g" \
    -e "s/w00/$new_cexp_rate/g" \
    -e "s/x00/$new_drop_rate/g" \
    -e "s/y00/$new_alzb_rate/g" \
    -e "s/z00/$new_alz_rate/g" \
    -e "s/abcd/$drop_amount/g" \
    > /etc/cabal/Data/Const.scp.tmp
    mv -f /etc/cabal/Data/Const.scp.tmp /etc/cabal/Data/Const.scp
    chmod 0777 /etc/cabal/Data/Const.scp
    echo "Reloading server configuration... "
    service cabal reload
    echo "done."
  ;;

  floating)
    echo -n "Starting floating rates... "    
    chmod 0777 /home/cabal/daemons/floating_rates_daemon.sh 
    echo "0 */1 * * * root /home/cabal/daemons/floating_rates_daemon.sh" >> /etc/cron.d/floating_rates
    echo "Done"
  ;;
                
  *)
    echo -e "\n Cabal Rates controller v1.0 by mrmagoo (Chumpy)"
    echo "================================================="
    echo "Configures your server rates or starts floating rates."
    echo "Floating rates configuration is done in"
    echo "/home/cabal/daemons/floating_rates_daemon.sh"
    echo "To stop floating rates run the static rates config script."
    echo "Usage: cabal_rates <command>"
    echo "<Commands>"
    echo " static   : Start the static rates config script."
    echo -e " floating : Start floating rates.\n"
    exit 1
esac
exit 0