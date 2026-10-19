<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

use Besnovatyj\Contracts\block\BlockType;

/**
 * Каталог типов блоков активной темы.
 *
 * Типы оформления (карточки, изображение с текстом поверх, виджеты провайдеров) принадлежат теме:
 * их разметка живёт рядом с разметкой темы и меняется вместе с ней. Тема объявляет их декларацией,
 * модуль блоков строит по схеме форму и выводит блок шаблоном темы.
 *
 * Два метода, потому что нужды у потребителей разные: админке нужен весь список (выбор типа), а вывод
 * блока на сайте знает id и не должен ради одного типа читать все.
 *
 * Производитель — пакет тем (`yii2-cms-themes`), реализацию он связывает через DI. Нет пакета тем —
 * нет биндинга: у модуля блоков остаются встроенные типы и типы модулей. Инверсия зависимостей (DIP),
 * как у {@see ThemeAreaCatalog}.
 */
interface ThemeBlockTypeCatalog
{
    /**
     * Все типы блоков активной темы.
     *
     * @return array<string, BlockType> ключ — {@see BlockType::$id}
     */
    public function blockTypes(): array;

    /**
     * Один тип по id; null — тема такой тип не объявляет.
     */
    public function blockType(string $id): ?BlockType;
}
