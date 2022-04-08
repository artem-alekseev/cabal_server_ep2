FROM bdobyns/centos4.6_i386

ENV container docker

COPY package /home/package

RUN rpm -Uvh /home/package/libmng-1.0.8-1.i386.rpm \
    && rpm -Uvh /home/package/qt-3.3.3-13.RHEL4.i386.rpm \
    && rpm -Uvh /home/package/lm_sensors-2.8.7-2.40.3.i386.rpm \
    && rpm -Uvh /home/package/net-snmp-5.1.2-11.EL4.7.i386.rpm \
    && rpm -Uvh /home/package/unixODBC-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh /home/package/unixODBC-devel-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh /home/package/unixODBC-kde-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh /home/package/freetds-unixodbc-0.64RC3-1.i386.rpm

RUN rpm -i -vv --noscripts /home/package/cabal-chnserverCB-1.0-2.rpm

COPY files/etc /etc
COPY files/usr /usr
COPY files/home/cabal /home/cabal

ENTRYPOINT ["linux32"]
CMD ["/bin/bash"]