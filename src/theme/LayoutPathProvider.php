<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

/**
 * Поставщик каталога layout'ов активной темы.
 *
 * Узкая абстракция, через которую тонкое ядро модулей ({@see CmsModule}) получает путь к
 * layout'ам, НЕ завися от конкретной реализации темизации. Компонент темы
 * (`view.theme`) реализует этот интерфейс; ядро проверяет `instanceof LayoutPathProvider`
 * вместо `instanceof Theme`, чем разрывается связанность ядро → пакет тем.
 *
 * Это применение принципа инверсии зависимостей (DIP): и ядро, и пакет тем зависят от данной
 * абстракции, а не друг от друга.
 */
interface LayoutPathProvider
{
    /**
     * Абсолютный путь к каталогу layout'ов активной темы.
     *
     * @return string путь вида `<themeBasePath>/layouts`
     */
    public function getLayoutsPath(): string;
}
