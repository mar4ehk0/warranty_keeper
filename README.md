# Site status

Хранилище гарантий на бытовую технику. Сфотографируй и выложи чек. Автоматически распознает текст на чеке.

## Развертывание

1. Клонировать проект


2. Создать `.env` файл
    ```bash
    cp docker/.env.example docker/.env && cp app/.env.example app/.env 
    ```
3. Отредактировать `docker/.env` файл. 

   Изменить переменные `APP_NAME=Status Site` и `COMPOSE_PROJECT_NAME=status_site`.  


5. В данном проекте в качестве хранилища данных используется json файлы `app/storage/. 

   Перед первым запуском необходимо, создать `sites_config.json`
    ```bash
    cp app/storage/sites_config.json.example app/storage/sites_config.json 
    ```
   _Описание структуры sites_config.json смотри ниже._  
   
