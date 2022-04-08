# .bash_profile

# Get the aliases and functions
if [ -f ~/.bashrc ]; then
	. ~/.bashrc
fi

# User specific environment and startup programs

PATH=$PATH:$HOME/bin
export FREETDS_UNIXODBC_CHARSET='cp936'
export PATH
unset USERNAME

