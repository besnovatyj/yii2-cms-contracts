<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\dashboard;

/**
 * Модуль предоставляет плитки (виджеты) для главной панели админки.
 *
 * Метод намеренно СТАТИЧЕСКИЙ и совместим с discovery модуля {@see \Besnovatyj\Contracts\module\DeclaresModule}:
 * набор плиток вычитывается без инстанцирования Yii-модуля. Сами плитки при этом рендерятся ЛЕНИВО —
 * дескриптор несёт лишь метаданные и FQCN виджета-плитки, а не готовый HTML.
 *
 * Модуль вправе объявить несколько плиток (например, «кратко» и «развёрнуто») — каждая со своим
 * стабильным {@see DashboardWidgetDescriptor::$id}. Раскладку (включённость/порядок) хранит и решает
 * модуль дашборда, а не модуль-поставщик.
 *
 * Собранный набор плиток активных модулей компилируется менеджером модулей в артефакт
 * `@config-dyn-gen/dashboardWidgets.php` (registry-gated), а не собирается в рантайме.
 */
interface ProvidesDashboardWidgets
{
    /**
     * @return DashboardWidgetDescriptor[] плитки, предоставляемые модулем
     */
    public static function dashboardWidgets(): array;
}
