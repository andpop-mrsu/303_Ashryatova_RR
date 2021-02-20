На компьютере должны быть установлены система **Powershell** и **SQLite3**.
Для создания и заполнения таблиц базы данных нужно запустить файл **db_init.bat**, который:
1) выполнит скрипт PowerShell make_db_init.ps1;
2) выполнит скрипт SQL db_init.sql.

Скрипт PowerShell make_db_init.ps1 парсит файлы *.csv и *.txt из каталога ./Task02/dataset/ и 
генерирует скрипт db_init.sql, который создает и заполяет таблицы базы данных movies_rating.db.
 