# Uruchomienie projektu

1. Instalacja zaleności

    composer install

2. Dodanie konfiguracji dostępu do bazy danych w pliku .env

3. Wykonanie migracji 

    php artisan migrate

4. Import pliku .csv

    php artisan file:import --file ../data.csv

5. Rekordy, które nie zostały zaimportowane zapisują się w plikach w folderze "storage/app/import-csv"

6. Uruchomienie serwera 

    php artisan serve
