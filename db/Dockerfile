FROM mcr.microsoft.com/mssql/server

USER root

COPY ./Backups.zip /var/opt/mssql/backup
WORKDIR /var/opt/mssql/backup
RUN unzip Backups.zip
COPY ./restoredb.sh ~/restoredb.sh
RUN wget https://packages.microsoft.com/config/ubuntu/20.04/prod.list | tee /etc/apt/sources.list.d/msprod.list
RUN apt update && apt install -y mssql-tools unixodbc-dev
RUN ln -s /opt/mssql-tools/bin/* /usr/local/bin/