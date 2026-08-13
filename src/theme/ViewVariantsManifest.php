<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\theme;

/**
 * Контракт файловой конвенции вариантов представления и формата их артефакта.
 *
 * Единый «стык» между производителем (сканер пакета тем, генерит артефакт при recompile/flush) и
 * потребителем (каталог-ридер, читает артефакт на запрос). Оба зависят от этого контракта, а не
 * друг от друга — как {@see ViewSourcesManifest} между modman и компонентом темы.
 *
 * Конвенция обнаружения (внутри оверлея темы, рекурсивно на любой глубине контроллёров/экшенов):
 * рядом с базовым представлением `…/{view}.php` лежит каталог `…/{view}.variants/` с файлами-
 * вариантами и опциональным {@see LABELS_FILE}. Пример для двух экшенов одного контроллёра:
 * ```
 * @themes/{theme}/modules/Blog/views/frontend/post/
 * ├── view.php
 * ├── view.variants/{landing.php, raw.php, _labels.php}
 * ├── tag.php
 * └── tag.variants/{wide.php, _labels.php}
 * ```
 * дают слоты `Blog:frontend/post/view` и `Blog:frontend/post/tag`.
 *
 * Артефакт — тема-зависимый файл `viewVariants.{theme}.php` (брат `themePathMap.{theme}.php`):
 * плоская мапа `slot => [ключ-варианта => метка]`.
 */
final class ViewVariantsManifest
{
    /**
     * Суффикс каталога вариантов рядом с базовым представлением (`{view}.variants`).
     */
    public const string VARIANTS_DIR_SUFFIX = '.variants';

    /**
     * Файл меток внутри каталога вариантов: возвращает `ключ-варианта => метка` (переводимо через
     * `Yii::t`). Отсутствует — метки берутся из имён файлов. В сам список вариантов не попадает.
     */
    public const string LABELS_FILE = '_labels.php';

    /**
     * Идентификатор слота: `{moduleId}:{путь-view}`.
     *
     * `moduleId` — ключ модуля в `Yii::$app->modules` (для представлений самого приложения —
     * {@see ViewSourcesManifest::APP_VIEWS_KEY}). `viewPath` — путь базового представления
     * относительно `views/`-корня, без расширения, со слэшами (`frontend/page/view`).
     *
     * @param string $moduleId идентификатор модуля-потребителя
     * @param string $viewPath путь базового представления относительно `views/`
     */
    public static function slot(string $moduleId, string $viewPath): string
    {
        return $moduleId . ':' . trim($viewPath, '/');
    }

    /**
     * Тема-зависимый путь артефакта из базового: `<dir>/viewVariants.{theme}.php`.
     *
     * Зеркалит схему `ThemePathMapService::cacheFile()`: `$baseFile` — уже разрезолвленный
     * (`Yii::getAlias`) путь базового параметра, реальные файлы лежат рядом с ним.
     *
     * @param string $baseFile  разрезолвленный путь базового параметра артефакта
     * @param string $themeName имя активной темы
     */
    public static function themedFile(string $baseFile, string $themeName): string
    {
        return dirname($baseFile) . '/viewVariants.' . $themeName . '.php';
    }
}
