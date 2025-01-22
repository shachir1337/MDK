<?php
$jsonData = '[
    {"city": "Москва", "temperature": 15, "condition": "облачно"},
    {"city": "Санкт-Петербург", "temperature": 22, "condition": "ясно"},
    {"city": "Екатеринбург", "temperature": 25, "condition": "дождь"},
    {"city": "Казань", "temperature": 19, "condition": "облачно"},
    {"city": "Новосибирск", "temperature": 21, "condition": "ясно"}
]';

$weatherData = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Ошибка декодирования JSON: ' . json_last_error_msg());
}

$citiesAbove20 = [];

foreach ($weatherData as $weather) {
    if ($weather['temperature'] > 20) {
        $citiesAbove20[] = $weather['city'];
    }
}

if (!empty($citiesAbove20)) {
    echo "Города с температурой выше 20 градусов:\n";
    foreach ($citiesAbove20 as $city) {
        echo "- $city\n";
    }
} else {
    echo "Нет городов с температурой выше 20 градусов.\n";
}
?>