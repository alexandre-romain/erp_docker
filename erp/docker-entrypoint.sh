#!/bin/bash

# Fonction pour attendre que MariaDB soit pr�t
wait_for_mariadb() {
    echo "Attente de MariaDB..."
    while ! mysqladmin ping --silent; do
        sleep 1
    done
    echo "MariaDB est pr�t."
}

# D�marrer MariaDB en arri�re-plan
service mysql start

# Attendre que MariaDB soit pr�t
wait_for_mariadb

# D�marrer Apache en mode foreground
exec apachectl -D FOREGROUND
