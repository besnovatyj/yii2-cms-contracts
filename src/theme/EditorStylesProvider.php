<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

/** Предоставляет стили контента активной темы для редактора. */
interface EditorStylesProvider
{
    /**
     * Возвращает публичные URL таблиц стилей в порядке подключения.
     *
     * @return list<string> Пустой список, если тема не объявляет стили редактора.
     */
    public function styles(): array;
}
