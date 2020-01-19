Структура:
1) core - папка с основными элементами системы (базовые классы и хелперы)
2) configs - папка с конфигурацией
3) db - папка с миграциями
4) libs - сторонние библиотеки, которых нет в базе packagist
5) app - основная папка проекта (Содержит в себе сервисы, модели и контроллеры)


Установка проекта:
1) Запустить "composer install" для установки зависимостей
2) Создать конфигурацию системы на базе конфигурации configs/config-local.template.php
3) В проекте используется менеджер миграций Phinx. 
    1.1 Запустить "vendor/bin/phinx init" для создания конфигурационного файла Phinx
    1.2 Редактировать конфигурационный файл согласно настройкам вашей базы данных ( по умолчанию phinx.yml)
    1.3 Запустить миграции с помощью команды "vendor/bin/phinx migrate -e development ". Для создания таблиц и наполнения базы данными
