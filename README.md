Структура:
core - папка с основными элементами системы (базовые классы и хелперы)
configs - папка с конфигурацией
db - папка с миграциями
libs - сторонние библиотеки, которых нет в базе packagist
app - основная папка проекта (Содержит в себе сервисы, модели и контроллеры)


Установка проекта:
1) Запустить "composer install" для установки зависимостей
2) Создать конфигурацию системы на базе конфигурации configs/config-local.template.php
3) В проекте используется менеджер миграций Phinx. 
    a) Запустить "vendor/bin/phinx init" для создания конфигурационного файла Phinx
    b) Редактировать конфигурационный файл согласно настройкам вашей базы данных ( по умолчанию phinx.yml)
    c) Запустить миграции с помощью команды "vendor/bin/phinx migrate -e development ". Для создания таблиц и наполнения базы данными