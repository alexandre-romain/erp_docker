#!/bin/bash

# Fonction pour attendre que MariaDB soit prêt
wait_for_mariadb() {
    echo "Attente de MariaDB..."
    while ! mysqladmin ping --silent; do
        sleep 1
    done
    echo "MariaDB est prêt."
}

# Démarrer MariaDB en arrière-plan
service mysql start

# Attendre que MariaDB soit prêt
wait_for_mariadb

# Démarrer Apache en mode foreground
exec apachectl -D FOREGROUND
