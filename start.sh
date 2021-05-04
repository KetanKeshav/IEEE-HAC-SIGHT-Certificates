echo "Package Update"
sudo apt-get update
echo "Installing Nginx"
sudo apt-get install nginx -y
echo "Installing MySQL"
sudo apt-get install mysql-server -y
echo "Installing PHP"
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.4-cli php7.4-fpm php7.4-curl php7.4-gd php7.4-mysql php7.4-mbstring php7.4-xml php7.4-bcmath zip unzip
echo "Modifying php.ini file"
sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/' /etc/php/7.4/fpm/php.ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 60M/' /etc/php/7.4/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 60M/' /etc/php/7.4/fpm/php.ini
echo "Restarting FPMs"
sudo systemctl restart php7.4-fpm
echo "Nginx Configuration"
cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak
cp nginx-conf.conf /etc/nginx/sites-available/default
nginx -t
systemctl restart nginx
echo "Composer Setup"
apt-get install composer -y
echo "Application Setup"
mkdir -p /var/www/html
chown -R www-data:www-data /home/ubuntu/XtremeCert/webapp
ln -s /home/ubuntu/XtremeCert/webapp /var/www/html
composer update
echo "Databse Setup"
mysql -e "CREATE DATABASE ieeextremeCert;"
mysql -e "CREATE USER 'ieeextreme'@'localhost' IDENTIFIED BY 'vJbuepauoTOSkDpgtIt29u7nnAnc8FdilAGYmQtaE8z9XWpZ3IfsdgUkH0jGMpnj8w';"
mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'ieeextreme'@'localhost';"
exit
echo "PHPMyAdmin"
sudo apt install phpmyadmin
ln -s /usr/share/phpmyadmin /home/ubuntu/XtremeCert/webapp/public
echo "DB Migrate"
php artisan migrate
php artisan DB:seed
