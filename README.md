# VK.com parser

Инструменты для работы с API vk.com

```
http://localhost/index.php - исполняемый файл
```

## config.json

```JavaScript
{
    "owner_id": "-1", // owner_id=-1 соответствует сообществам, owner_id=1 соответствует пользователям
    "count": {
        "posts": 5, // Количество постов для сбора комментариев
        "comments": 5
    },
    "version": 5,
    "filename": "filename", // Имя экспортируемого файла
    "export": "json" // Формат экспортируемого файла
}
```
