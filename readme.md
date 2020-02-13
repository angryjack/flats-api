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

## Запрос на создание 
```POST http://flats.test/api/add?city=Москва&district=Аэропорт&residential_block=ЖК Art House&building=1&address=улица 1, дом 6&floor=2&rooms=3&area=87&price=55``` 

## Запрос на поиск
```POST http://flats.test/api/search?city=Москва```

Поддерживает такие параметры поиска:
```city - город
district - район
address - адрес
residentialBlock - название ЖК
building - корпус
maxFloors - максимальное кол-во этажей
floor - этаж
rooms - кол-во комнат
area - площадь
price - цена
```
