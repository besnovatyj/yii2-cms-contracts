<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

/**
 * Контракт формата манифеста источников представлений `moduleViewSources.php`.
 *
 * Манифест — тема-НЕзависимая проекция набора установленных модулей: плоская мапа
 * `moduleId => sourceAlias`, где `sourceAlias` — алиасный путь к собственному `views/`-каталогу
 * модуля (`@vendor/...`, `@root/packages/...` в dev или `@modules/...`). Плюс единственный
 * корневой ключ {@see APP_VIEWS_KEY} для представлений самого приложения.
 *
 * Производитель — менеджер модулей (перегенерирует при install/uninstall). Потребитель —
 * компонент темы, который накладывает поверх активную тему по единой overlay-конвенции
 * {@see overlaySubPath()}. Оба зависят от этого контракта, а не друг от друга.
 *
 * Пример:
 * ```php
 * return [
 *     ViewSourcesManifest::APP_VIEWS_KEY => '',              // корневой оверлей: {theme}/views
 *     'Menu'   => '@vendor/besnovatyj/yii2-cms-menu/src/views',
 *     'Person' => '@root/packages/besnovatyj/yii2-cms-person/src/views',
 *     'User'   => '@modules/User/views',
 * ];
 * ```
 */
final class ViewSourcesManifest
{
    /**
     * Ключ корневого оверлея представлений приложения (`@app/views`).
     * Оверлей в теме для него — просто `{theme}/views`, без сегмента `modules/...`.
     */
    public const string APP_VIEWS_KEY = '@app/views';

    /**
     * Единая overlay-конвенция: относительный путь оверлея модуля внутри каталога темы.
     *
     * `moduleId` уникален (ключ в `Yii::$app->modules`), поэтому деление vendor/app не нужно —
     * оверлей любого модуля единообразно зеркалит его собственный `views/`.
     *
     * @param string $moduleId идентификатор модуля
     * @return string относительный путь вида `modules/{moduleId}/views`
     */
    public static function overlaySubPath(string $moduleId): string
    {
        return "modules/{$moduleId}/views";
    }
}
