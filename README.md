Yii 2 REST Project Boilerplate
==============================

Yii 2 REST Project Boilerplate is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing RESTful API's.

It is based from a Yii 2 Advanced Project Template, it includes two tiers: API, and console (for applying migrations), each of which
is a separate Yii application.

This boilerplate contains:
  * User creation
  * External action for check if user email exists
  * Authentication
  * Upload files
  * Migrations for User and Upload
  
  
## Задание 3
```mysql
SELECT
  start_interval  AS 'FROM',
  finish_interval AS 'TO'
FROM (
       SELECT
         t1.id AS start_interval,
         t2.id AS current_id,
         (
           SELECT id
           FROM test t3
           WHERE t3.id > t1.id
           LIMIT 1
         )     AS finish_interval
       FROM test t1
         LEFT JOIN test t2 ON t2.id = t1.id + 1
     ) T
WHERE start_interval  IS NOT NULL
  AND current_id      IS NULL
  AND finish_interval IS NOT NULL

```

## Задание 4

Основная логика лежит в папке `api/modules/v1`

Задеплоил приложение на свой хостинг по адресу http://test4.chernov-sergey.ru

`GET /api/web/v1/users` - Получить список пользователей, а также пройденные задания с оценками (только последние результаты по каждому заданию);

`GET /api/web/v1/users?expand=answers` - получить полный список ответов всех пользоватлей;

`GET /api/web/v1/users/:id` - посмотреть статистику конктретного пльзователя;

`POST /api/web/v1/users` - добавить пользователя;


`GET /api/web/v1/tasks` - получить список вопросов;

`POST /api/web/v1/tasks` - добавить вопрос;

`POST /api/web/v1/answers` - добавить ответ к вопросу;
