rm -rf var/cache var/page_cache var/view_preprocessed generated/code generated/metadata pub/static/frontend/ pub/static/adminhtml/

echo "* Start Compile *"
echo ".... please be patient ....................."

php bin/magento setup:upgrade
php bin/magento setup:di:compile

# php bin/magento setup:static-content:deploy -t Sams/abeeIndo en_US id_ID -f
php bin/magento setup:static-content:deploy en_US id_ID -f

php bin/magento cache:clean

echo "chmod -R 777 var/ generated/ pub/"
chmod -R 777 var/ generated/ pub/

#echo "* Reindex Catalog"
#php bin/magento indexer:reindex


echo "chown -R :www-data ."
chown -R :abby .

echo "* Compile Done * -- Thank you for waiting .."

