<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\sitemap;

/**
 * Один адрес карты сайта, отданный модулем-провайдером {@see SitemapProvider} модулю карты.
 *
 * Адрес хранится как `route` + `params`, а НЕ как готовая строка URL — по той же причине, что и в
 * {@see \Besnovatyj\Contracts\search\SearchDocument}: короткий адрес сущности администратор меняет в
 * модуле алиасов в любой момент, и записанная строка молча протухает, а карта начинает водить
 * краулера по редиректам. Модуль карты строит абсолютный URL через `frontendUrlManager` в момент
 * сборки, получая ровно одну каноническую форму.
 *
 * Один и тот же DTO питает XML-карту и HTML-карту: `title` и `depth` нужны только человеку,
 * `lastModified`/`changeFrequency`/`priority` — только роботу. Разводить их по двум структурам
 * значило бы завести два источника правды, которые рано или поздно разойдутся.
 */
final readonly class SitemapUrl
{
    /**
     * @param string               $route           Внутренний роут фронтенда (напр. `/Blog/post/view`).
     * @param array<string, mixed> $params          Параметры роута (`['id' => 42]`, `['slug' => 'about']`).
     * @param string|null          $title           Заголовок для HTML-карты. null — адрес попадёт только
     *                                              в XML (у страницы пагинации показывать нечего).
     * @param int|null             $lastModified    Дата последнего изменения, Unix-timestamp. Провайдер
     *                                              обязан привести к нему своё представление
     *                                              (`strtotime()` для DATETIME-колонок). null — элемент
     *                                              `<lastmod>` не пишется: отсутствие честнее выдуманной
     *                                              даты, по которой краулер строит расписание переобхода.
     * @param ChangeFrequency|null $changeFrequency Переопределение частоты для этого адреса; null —
     *                                              берётся значение раздела.
     * @param float|null           $priority        Переопределение приоритета, 0.0…1.0; null — значение
     *                                              раздела. Уместно для «главной» записи раздела.
     * @param int                  $depth           Глубина вложенности для отступа в HTML-карте (дерево
     *                                              разделов). 0 — верхний уровень.
     * @param bool                 $inHtmlMap       Показывать ли адрес на HTML-карте.
     */
    public function __construct(
        public string $route,
        public array $params = [],
        public ?string $title = null,
        public ?int $lastModified = null,
        public ?ChangeFrequency $changeFrequency = null,
        public ?float $priority = null,
        public int $depth = 0,
        public bool $inHtmlMap = true,
    ) {
    }
}
