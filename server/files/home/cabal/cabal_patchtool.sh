#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_autorestart.sh script must be run as root." 1>&2
   exit 1
fi

echo -e "\n Cabal patch maker v1.00"
echo "========================="
        
function packfile {
  echo -n "${2##*/} "
  encpack -c < $1 > $2	
}

function unpackfile {
  echo -n "${2##*/} "
  encpack -d < $1 > $2	
}

case "$1" in

  pack)
        echo -n "Packing files... "
        packfile /root/clientfiles/encfiles/cabal.txt /root/clientfiles/clientpatch/data/cabal.enc
        packfile /root/clientfiles/encfiles/cabal_msg.txt /root/clientfiles/clientpatch/data/cabal_msg.enc
        packfile /root/clientfiles/encfiles/caz.txt /root/clientfiles/clientpatch/data/caz.enc
        packfile /root/clientfiles/encfiles/caz_msg.txt /root/clientfiles/clientpatch/data/caz_msg.enc
        packfile /root/clientfiles/encfiles/cont.txt /root/clientfiles/clientpatch/data/cont.enc
        packfile /root/clientfiles/encfiles/cont_msg.txt /root/clientfiles/clientpatch/data/cont_msg.enc
        packfile /root/clientfiles/encfiles/Data.txt /root/clientfiles/clientpatch/data/Data.enc
        packfile /root/clientfiles/encfiles/extra_obj.txt /root/clientfiles/clientpatch/data/Map/extra_obj.enc
        packfile /root/clientfiles/encfiles/extra_obj_msg.txt /root/clientfiles/clientpatch/data/Map/extra_obj_msg.enc
        packfile /root/clientfiles/encfiles/item.txt /root/clientfiles/clientpatch/data/Item/item.enc
        packfile /root/clientfiles/encfiles/help.txt /root/clientfiles/clientpatch/data/help.enc
        packfile /root/clientfiles/encfiles/klog.txt /root/clientfiles/clientpatch/data/klog.enc
        packfile /root/clientfiles/encfiles/language.txt /root/clientfiles/clientpatch/data/language.enc
        packfile /root/clientfiles/encfiles/maze.txt /root/clientfiles/clientpatch/data/Maze/maze.enc
        packfile /root/clientfiles/encfiles/mob.txt /root/clientfiles/clientpatch/data/Monster/mob.enc
        packfile /root/clientfiles/encfiles/msg.txt /root/clientfiles/clientpatch/data/msg.enc
        packfile /root/clientfiles/encfiles/script.txt /root/clientfiles/clientpatch/data/NPC/script.enc
        packfile /root/clientfiles/encfiles/script_msg.txt /root/clientfiles/clientpatch/data/NPC/script_msg.enc
        echo "All ok."

        d=`date "+%d-%h-%Y-%H%M%S"`
        echo -ne "\nZipping client patch to /root/clientfiles/patch-$d).zip... "
        cd /root/clientfiles/clientpatch
        zip -rq9 /root/clientfiles/clientpatch-$d.zip *
        echo "done."

        echo -e "\nNow copy the following file to Windows and install it on your game clients."
        echo -e "/root/clientfiles/clientpatch-$d).zip\n"          
    ;;

  unpack)
        echo -n "Unpacking files... "
        unpackfile /root/clientfiles/clientpatch/data/cabal.enc /root/clientfiles/encfiles/cabal.txt
        unpackfile /root/clientfiles/clientpatch/data/cabal_msg.enc /root/clientfiles/encfiles/cabal_msg.txt
        unpackfile /root/clientfiles/clientpatch/data/caz.enc /root/clientfiles/encfiles/caz.txt
        unpackfile /root/clientfiles/clientpatch/data/caz_msg.enc /root/clientfiles/encfiles/caz_msg.txt
        unpackfile /root/clientfiles/clientpatch/data/cont.enc /root/clientfiles/encfiles/cont.txt
        unpackfile /root/clientfiles/clientpatch/data/cont_msg.enc /root/clientfiles/encfiles/cont_msg.txt
        unpackfile /root/clientfiles/clientpatch/data/Data.enc /root/clientfiles/encfiles/Data.txt
        unpackfile /root/clientfiles/clientpatch/data/Map/extra_obj.enc /root/clientfiles/encfiles/extra_obj.txt
        unpackfile /root/clientfiles/clientpatch/data/Map/extra_obj_msg.enc /root/clientfiles/encfiles/extra_obj_msg.txt
        unpackfile /root/clientfiles/clientpatch/data/Item/item.enc /root/clientfiles/encfiles/item.txt
        unpackfile /root/clientfiles/clientpatch/data/help.enc /root/clientfiles/encfiles/help.txt
        unpackfile /root/clientfiles/clientpatch/data/klog.enc /root/clientfiles/encfiles/klog.txt
        unpackfile /root/clientfiles/clientpatch/data/language.enc /root/clientfiles/encfiles/language.txt
        unpackfile /root/clientfiles/clientpatch/data/Maze/maze.enc /root/clientfiles/encfiles/maze.txt
        unpackfile /root/clientfiles/clientpatch/data/Monster/mob.enc /root/clientfiles/encfiles/mob.txt
        unpackfile /root/clientfiles/clientpatch/data/msg.enc /root/clientfiles/encfiles/msg.txt
        unpackfile /root/clientfiles/clientpatch/data/NPC/script.enc /root/clientfiles/encfiles/script.txt
        unpackfile /root/clientfiles/clientpatch/data/NPC/script_msg.enc /root/clientfiles/encfiles/script_msg.txt
        echo " All ok."
    ;;

            
  *)
        echo "Uses the enc (un)packing tool by Phantom* to pack and unpack enc files."
        echo "Looks in /root/clientfiles/clientpatch/data for enc files"
        echo "Looks in /root/clientfiles/encfiles for decoded enc files"
        echo "Usage: cabal_patchtool <command>"
        echo "<Commands>"
        echo " pack   : Packs enc files to the clientpatch directory."
        echo -e " unpack : Unpacks enc files to the encfiles directory.\n"
        exit 1
esac
exit 0