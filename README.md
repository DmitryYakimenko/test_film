# Реализуется архитектува по принципу MVC
- controllers - В этой папке хранятся контроллеры. Используются для оброботки даних пользователя и БД.
- db - Здесь хранится класс подключения к БД и файл конфигувации БД. 
- js - Здесь находяться файли JavaScript
- models - В этой папке хранятся модели. Используются для роботи с БД. 
- views - В этой папке хранятся представления. Используются для представления даних на странице.
- autoload.php - Класс для подключения классов.
- index.php - Точка входа в приложение.
- init.php - Класс приложения.
- router.php - Класс для парсинга url.
# Ход работи приложения
1. В index.php подключается (autoload.php, init.php). Запускается метод run класса Init и передается текущий url
2. Далие подключается класс Router которий розбивает url в такой формат controller/action/param1/param2/...
3. Далие обьявляется класс контроллера и запускается нужный метод.
4. В методах контроллера обьявляются нужные модели.
5. Далие в контроллере фовмируются дание для представления.
6. В классе Init обьявляется представление  
# Инструкция по запуску
1. В файле db/db_config.php прописать конфиги для БД.
2. Выполнить dump БД в db/dump.sql. 
