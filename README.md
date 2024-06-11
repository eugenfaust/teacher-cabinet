# Teacher Cabinet
Персональный кабинет для репетитора и его учеников.
## Возможности
- Установка расписания занятий
- Загрузка и скачивание учебных материалов персонально для каждого ученика
- Уведомления о новых заданиях/конспектах/занятиях напрямую в Telegram Bot
- Добавление/изменение/удаление учеников
- Возможность расширения проекта путем подключения внешних сервисов оплаты
## Запуск
- Склонировать репозиторий и настроить .env файл
- Установить зависимости и сбилдить фронт часть с помощью команд `composer install` `npm install` `npm run build`
- Произвести миграции с сидом для установки дефолтной учетной записи администратора `php artisan migrate --seed`
- Запустить проект `php artisan serve` либо через docker-compose
