FROM bdobyns/centos4.6_i386

ENV container docker

# ENV TINI_VERSION v0.19.0
# ADD https://github.com/krallin/tini/releases/download/${TINI_VERSION}/tini-i386 /tini
# RUN chmod +x /tini
# ENTRYPOINT ["/tini", "--"]

# RUN yum update; yum -y install unixODBC unixODBC-devel unixODBC-kde lm_sensors

RUN rm /etc/yum.repos.d/*
COPY yum.conf /etc/yum.conf
COPY CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo

COPY package /home/package
COPY cabal_install.sh /home/package/cabal_install.sh

WORKDIR /home/package

RUN rpm -Uvh libmng-1.0.8-1.i386.rpm \
    && rpm -Uvh qt-3.3.3-13.RHEL4.i386.rpm \
    && rpm -Uvh lm_sensors-2.8.7-2.40.3.i386.rpm \
    && rpm -Uvh net-snmp-5.1.2-11.EL4.7.i386.rpm \
    && rpm -Uvh unixODBC-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh unixODBC-devel-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh unixODBC-kde-2.2.11-1.RHEL4.1.i386.rpm \
    && rpm -Uvh freetds-unixodbc-0.64RC3-1.i386.rpm

# RUN curl -ko /tmp/bash-3.0-19.7.i386.rpm http://ftp.iij.ad.jp/pub/linux/centos-vault/4.7/os/i386/CentOS/RPMS/bash-3.0-19.7.i386.rpm
# RUN rpm -Uvh /tmp/bash-3.0-19.7.i386.rpm

RUN rpm -i -vv --noscripts cabal-chnserverCB-1.0-2.rpm

# RUN yum -y install glibc.i686 libgcc.i686 libstdc++.i686
# RUN yum -y install unixODBC.i686
# RUN yum -y install unixODBC-devel.i686
# RUN yum -y install unixODBC-kde --skip-broken
# RUN yum -y install lm_sensors
# RUN yum -y install dstat
# RUN yum -y install freetds
# RUN yum -y install net-snmp --skip-broken
# RUN yum -y install openssl097a db4 
# RUN rpm -Uvh /home/package/cabal-chnserverCB-1.0-2.rpm
COPY files/etc /etc
COPY files/usr /usr
COPY files/home/cabal /home/cabal

ENTRYPOINT ["linux32"]
CMD ["/bin/bash"]