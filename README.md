Приложение по расчёту скоринга

Подключение к БД в `app/.env`

Запустить сервер: `symfony server:start`

Переход в директорию приложения: `cd app`

Применить миграции: `bin/console d:m:m`

Загрузить фикстуры: `bin/console d:f:l`

Команда для расчёта и вывода скоринга: `bin/console app:scoring`

Роуты:
* Форма регистрации: `/create`
* Список клиентов: `/list`

Запустить тесты: `symfony php bin/phpunit`

Code-style по PSR при помощи `https://cs.symfony.com/`
