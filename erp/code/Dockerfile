# Utiliser Debian Jessie comme base
FROM debian:8

# Ajouter les dépôts archivés nécessaires pour Jessie
RUN echo "deb http://archive.debian.org/debian/ jessie main" > /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian-security/ jessie/updates main" >> /etc/apt/sources.list && \
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until

# Préconfigurer MariaDB pour définir le mot de passe root avant l'installation
RUN echo "mariadb-server-10.0 mysql-server/root_password password GetinDOC\$99" | debconf-set-selections && \
    echo "mariadb-server-10.0 mysql-server/root_password_again password GetinDOC\$99" | debconf-set-selections

# Mettre à jour et installer les paquets
RUN apt-get update -o Acquire::Check-Valid-Until=false && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --force-yes \
        wget \
        apache2 \
        libapache2-mod-php5 \
        php5 \
        php5-mysql \
        mariadb-server-10.0 \
        mariadb-client-10.0 \
        unzip && \
    apt-get clean

# Supprimer le fichier d'accueil par défaut d'Apache
RUN rm -f /var/www/html/index.html

# Préparer un répertoire sécurisé pour phpMyAdmin en dehors du document root
RUN mkdir -p /usr/share/phpmyadmin

# Télécharger PHPMyAdmin compatible avec PHP 5.5 et l'extraire correctement
RUN wget https://files.phpmyadmin.net/phpMyAdmin/4.4.15.10/phpMyAdmin-4.4.15.10-all-languages.zip -O /tmp/phpmyadmin.zip && \
    mkdir /tmp/phpmyadmin_extract && \
    unzip /tmp/phpmyadmin.zip -d /tmp/phpmyadmin_extract && \
    mv /tmp/phpmyadmin_extract/phpMyAdmin-4.4.15.10-all-languages/* /usr/share/phpmyadmin/ && \
    rm -rf /tmp/phpmyadmin.zip /tmp/phpmyadmin_extract

# Ajouter le fichier de configuration pour PHPMyAdmin
COPY config.inc.php /usr/share/phpmyadmin/config.inc.php

# Copier les fichiers PHP de votre application dans le répertoire du document root
COPY code /var/www/html/

# Ajouter le script SQL pour initialiser la base de données
COPY init.sql /docker-entrypoint-initdb.d/

# Configurer Apache pour utiliser un seul alias /phpma pour phpMyAdmin avec les permissions nécessaires
RUN echo "Alias /phpma /usr/share/phpmyadmin\n\
<Directory /usr/share/phpmyadmin>\n\
    Options Indexes FollowSymLinks\n\
    DirectoryIndex index.php\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/phpmyadmin-alias.conf && \
    a2enconf phpmyadmin-alias && \
    a2enmod rewrite

# S'assurer que les permissions sont correctes pour phpMyAdmin
RUN chown -R www-data:www-data /usr/share/phpmyadmin && \
    chmod -R 755 /usr/share/phpmyadmin && \
    # Optionnel : Assurez-vous qu'il n'y a pas de répertoire phpmyadmin dans le document root
    rm -rf /var/www/html/phpmyadmin

# Modifier les limites de PHP pour permettre des uploads jusqu'à 250 Mo
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 250M/' /etc/php5/apache2/php.ini && \
    sed -i 's/post_max_size = .*/post_max_size = 250M/' /etc/php5/apache2/php.ini && \
    sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php5/apache2/php.ini

# Initialisation manuelle de MariaDB pour configurer root
RUN service mysql start && \
    mysql -u root -pGetinDOC\$99 -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('GetinDOC\$99');" && \
    mysql -u root -pGetinDOC\$99 -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY 'GetinDOC\$99' WITH GRANT OPTION;" && \
    mysql -u root -pGetinDOC\$99 -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'GetinDOC\$99' WITH GRANT OPTION;" && \
    mysql -u root -pGetinDOC\$99 -e "FLUSH PRIVILEGES;" && \
    service mysql stop

# Démarrer Apache pour finaliser la configuration
RUN service apache2 start && service apache2 reload

# Ajouter le script d'entrée
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer le port 80
EXPOSE 80

# Définir le script comme commande par défaut
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
