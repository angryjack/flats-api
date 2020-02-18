# Тестовое задание

Структура проекта:
- App\Models\Flat - Модель квартиры
- App\Models\City - Модель города
- App\Models\District - Модель района
- App\Models\ResidentialBlock - Модель ЖК
- App\Models\Building - Модель Корпуса ЖК


## Инициализация
1. Скопировать .env и прописать данные для подключения к БД.
2. Запустить ```composer install```
3. Запустить миграции ```php artisan make:migration```

## Добавление квартиры
Пример запроса:  
```POST http://flats.test/api/add?city=Москва&district=Аэропорт&residential_block=ЖК Art House&building=1&address=улица 1, дом 6&floor=2&rooms=3&area=87&max_floors=10``` 

Статусы ответа:  
```422``` При ошибке валидации данных. Возварщается ассоциативный массив, где ключ - поле в котором произошла ошибка валидации, а значение - описание ошибки.  
```200``` При успешном добавлении. Возвращается созданный объект.

Параметры
```
city
district
address
residential_block - Жилой комплекс
building - Корпус
max_floors
floor
rooms
area
price
```

## Поиск
Пример запроса:  
```POST http://flats.test/api/search?city=Москва```

Поддерживаемые параметры поиска:
```page - страница поиска
city - город
district - район
address - адрес
residential_block - Жилой комплекс 
building - корпус
max_floors - максимальное кол-во этажей
floor - этаж
rooms - кол-во комнат
area - площадь квартиры
price - стоимость аренды
```
