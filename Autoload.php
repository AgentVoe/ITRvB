<?php

spl_autoload_register(function ($className) {
    // Определяем базовый путь к проекту
    $baseDir = __DIR__ . '/src/';

    // Преобразуем имя класса в путь к файлу
    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classFile = str_replace('_', DIRECTORY_SEPARATOR, $classFile);

    // Добавляем расширение .php
    $file = $baseDir . $classFile . '.php';

    // Проверяем существование файла и подключаем его
    if (file_exists($file)) {
        require $file;
    }
});

?>