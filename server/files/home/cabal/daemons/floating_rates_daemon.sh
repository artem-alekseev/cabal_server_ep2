#!/bin/sh

logfile=/var/log/cabal/floating_rates.log

# Minimum rate 1 = 1x
base_rate=1
# Maximum rate 5 = 5x
max_rate=5
# Items per drop
dropcount=1

n=1
while [ $n -le $base_rate ]; do
  n=$RANDOM
  let "n %= $max_rate"
done

t=1
while [ $t -le 1 ]; do
  t=$RANDOM
  let "t %= 7"
done

let new_exp=100*$base_rate
let new_skillexp=100*$base_rate
let new_craftexp=100*$base_rate
let new_droprate=100*$base_rate
let new_alzrate=100*$base_rate
let new_alzbrate=100*$base_rate

if [ $t -eq 1 ]; then
  let new_exp=$n*100
  newtype="EXP"
elif [ $t -eq 2 ]; then
  let new_skillexp=$n*100
  newtype="Skill EXP"
elif [ $t -eq 3 ]; then
  let new_craftexp=$n*100
  newtype="Craft EXP"
elif [ $t -eq 4 ]; then
  let new_droprate=$n*100
  newtype="Droprate"
elif [ $t -eq 5 ]; then
  let new_alzrate=$n*100
  newtype="Alz Rate"
elif [ $t -eq 6 ]; then
  let new_alzbrate=$n*100
  newtype="Alz Bomb Rate"
fi
 
sed /etc/cabal/templates/Const.cfg \
-e "s/u00/$new_exp/g" \
-e "s/v00/$new_skillexp/g" \
-e "s/w00/$new_craftexp/g" \
-e "s/x00/$new_droprate/g" \
-e "s/y00/$new_alzbrate/g" \
-e "s/z00/$new_alzrate/g" \
-e "s/abcd/$dropcount/g" \
> /etc/cabal/Data/Const.scp
chmod 0777 /etc/cabal/Data/Const.scp

echo "`date`: Selected $n x as rate for $newtype" | tee -a $logfile

service cabal reload