<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\block;

/**
 * Тип блока: схема полей, которые заполняет администратор, и шаблон, который рисует блок на сайте.
 *
 * Блок с типом — это данные (`data`), а не готовый HTML: менеджер заполняет форму, разметку рисует
 * шаблон. Так в место темы можно положить «три карточки в ряд» или «витрину спектаклей», не давая
 * менеджеру ломать вёрстку.
 *
 * Типы объявляют: модуль блоков (встроенные), активная тема ({@see \Besnovatyj\Contracts\theme\ThemeBlockTypeCatalog})
 * и контентные модули ({@see BlockTypeProvider}). Нейтральный DTO без зависимостей: на него ссылаются
 * и производители типов, и модуль блоков, не завися друг от друга (DIP).
 */
final readonly class BlockType
{
    /**
     * @param string                    $id           Идентификатор типа. У типов модулей — локальный в пределах
     *                                                модуля, полный id составляет модуль блоков (см. {@see BlockTypeProvider}).
     * @param string                    $label        Название для админки.
     * @param string                    $view         Шаблон вывода: путь к view-файлу, допускается Yii-алиас.
     *                                                Рендерится через `View::renderFile()`, поэтому шаблон модуля
     *                                                тема перекрывает обычным overlay представлений модуля.
     * @param array<string, array>      $fields       Схема полей: `имя => описание`. Формат описания задаёт модуль
     *                                                блоков (readme, раздел «Типы блоков»).
     * @param string                    $hint         Подсказка администратору: что это за блок и куда он подходит.
     * @param class-string<BlockDataProvider>|null $dataProvider Поставщик дополнительных данных для шаблона
     *                                                (выборка из БД модуля); null — шаблону хватает полей блока.
     *                                                FQCN строкой: класс создаётся только при выводе блока.
     */
    public function __construct(
        public string $id,
        public string $label,
        public string $view,
        public array $fields = [],
        public string $hint = '',
        public ?string $dataProvider = null,
    ) {
    }
}
