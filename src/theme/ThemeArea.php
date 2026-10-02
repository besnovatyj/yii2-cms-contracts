<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

/**
 * Место темы, куда администратор кладёт управляемое содержимое (блоки).
 *
 * Тема объявляет свои места декларацией (их список отдаёт {@see ThemeAreaCatalog}), а в разметке
 * вызывает виджет модуля блоков с тем же идентификатором. Каркас места (обёртка, кнопки, скрипты)
 * остаётся в теме, из админки приходит только начинка.
 *
 * Нейтральный DTO без зависимостей: на него ссылаются и пакет тем (производитель списка), и модуль
 * блоков (потребитель), не завися друг от друга.
 */
final readonly class ThemeArea
{
    /**
     * @param string $id    Идентификатор места, тот же, что тема передаёт виджету при выводе.
     * @param string $label Человекочитаемое имя для админки.
     * @param string $hint  Подсказка администратору: где место на странице и какая начинка ему подходит.
     * @param int    $sort  Порядок в списке мест (меньше — выше).
     */
    public function __construct(
        public string $id,
        public string $label,
        public string $hint = '',
        public int $sort = 0,
    ) {
    }
}
