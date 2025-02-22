# Popup-for-Yii2
Creating pop-ups on the framework Yii2
# Пример создания всплывающих окон (попапов) для сайта на платфлорме Yii2

# Общее описание задачи.

1. Реализовать сущность Попапа на платформе yii2.
	- Название
	- Текст содержимого
	- Включен он или выключен

2. Реализовать административную часть CRUD операции для попапа.

3. Реализовать статистику по количеству показов. 
В списке попапов для каждой записи должно быть выведено количество показов данного попапа.

4. Реализовать демонстративную страницу на которой будет установлен код попапа.

5. Реализовать произвольный эффект появления и закрытия всплывающего окна (анимацию).
Примечание: Все таблицы для БД должны быть созданы при помощи миграций.

6. После создания попапа должна генерироваться ссылка на js скрипт, который возможно поставить на любой сайт. 
Скрипт устанавливается единожды. 
Все внесенные в попап изменения должны быть применены к уже установленным попапам.
При подключении данного скрипта через 10 секунд после загрузки страницы должно отображаться созданное пользователем всплывающее окно. 
Если попап был отключен пользователем в административной части, то он не должен быть показан.
По каждому попапу в административной части должна быть информация о количестве показов.

# Решение задачи

1. Сперва необходимо создать таблицу в базе данных для хранения настроек попапов. 
Для этого создадим миграцию, которая создаст таблицу, где будут храниться все необходимые параметры, с помощью команды:
```bash
php yii migrate/create create_popup_settings_table
```
Обновить полученный код в следующем виде:

    public function up()
    {
        $this->createTable('popup', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(true),
            'width' => $this->integer()->defaultValue(600),
            'height' => $this->integer()->defaultValue(400),
            'display_count' => $this->integer()->defaultValue(0),
            'show_after' => $this->integer()->defaultValue(10), // время задержки перед всплыитием окна в секундах, по умолчанию 10 секунд
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('popup');
    }

2. Запустить миграцию yii migrate
```bash
php yii migrate
```
3. Создать модель для работы с таблицей:
```bash
php  yii gii/model --tableName=popup --modelClass=Popup
```
и внести изменения в код (см. пример /models/Popup.php)

4. Создать контроллер `Popup` с CRUD (базовые функции, используемые при работе с базами данных: создание, чтение, модификация, удаление).
Выполните команду: 
```bash
php yii gii/crud --modelClass=app\models\Popup --controllerClass=app\controllers\PopupController
```
и в него внести изменения, в частности это касается функции генерации скрипта JS (см. пример /controllers/PopupController.php)

5. Создать отдельный шаблон _script.php (см. /views/popup/_script.php)

6. Подготовить демо-страницу для вызова Попапа (см. пример /views/site/demo.php).

7. Внести изменения в config/web.php (см. пример /config/web.php).

8. Для дополнительных эффектов анимации можно внести изменения в css-файл (см. пример \views\web\css\site.css).

### Итог
- Создана сущность `Popup` с CRUD.
- Реализована статистика показов (админка доступна по адресу "Site_URL"/popup/index).
- Настройки попапа можно менять в админке без необходимости изменять содержимое самого JS-файла.
- Добавлена демонстративная страница с анимацией по адресу "Site_URL"/demo).
- Сгенерирован JS-скрипт для подключения к страницам (в примере использован JS-скрипт /web/js/popup-5.js для подключения к пятому Попапу из таблицы `popup` - SELECT * FROM `popup` WHERE `id` = 5 )
для этого в php-коде демо-страницы включаем строчки:
```
use app\models\Popup;
$popupData = Popup::findOne(5);
```

# Примечание
На тестовой демо-странице demo.php использован шаблон на основе bootstrap5, котрый можно вынести в отдельный файл,
на каждой странице где требуется запуск попапа просто вставлять: require_once($_SERVER["DOCUMENT_ROOT"]."/popup_template.php");
