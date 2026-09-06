<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\search;

/**
 * Единица индексации — одна запись контента, отданная модулем-провайдером {@see SearchableProvider}
 * модулю поиска.
 *
 * Провайдер отдаёт СЫРЫЕ данные сущности, ничего не подготавливая: HTML не чистит, шорткоды не
 * раскрывает, текст не обрезает и не стеммит. Вся нормализация — единая политика модуля поиска,
 * иначе десять модулей начнут чистить текст десятью разными способами, а смена политики потребует
 * правки десяти пакетов.
 *
 * Ссылка на документ хранится как `route` + `params`, а НЕ как готовый URL: короткий URL сущности
 * администратор может изменить в модуле алиасов в любой момент, и сохранённая строка молча
 * протухнет. Модуль поиска строит ссылку через `Url::to()` в момент вывода выдачи.
 */
final readonly class SearchDocument
{
    /**
     * @param string               $type     Ключ источника из {@see SearchSource::$type} (`blog.post`).
     * @param int|string           $entityId Первичный ключ сущности в её собственной таблице. Пара
     *                                       `type` + `entityId` уникально адресует документ в индексе.
     * @param string               $route    Внутренний роут фронтенда (напр. `/Blog/post/view`).
     * @param array<string, mixed> $params   Параметры роута (напр. `['id' => 42]`, `['slug' => 'about']`).
     * @param string               $title    Заголовок. Индексируется с повышенным весом и выводится
     *                                       ссылкой в выдаче.
     * @param string               $text     Основной текст. Допускается сырой HTML с шорткодами —
     *                                       модуль поиска приведёт его к чистому тексту сам.
     * @param string               $keywords Дополнительные слова для индекса, не показываемые в выдаче:
     *                                       теги, категория, артикул, бренд, синонимы названия.
     * @param string|null          $excerpt  Готовый анонс для карточки выдачи. null — модуль поиска
     *                                       соберёт фрагмент из `text` сам (или подсветит совпадение,
     *                                       если движок это умеет).
     * @param int|null             $date     Дата публикации, Unix-timestamp. Провайдер обязан привести
     *                                       к нему своё представление (`strtotime()` для DATETIME-колонок).
     *                                       Используется для сортировки по свежести и вывода в карточке.
     * @param string|null          $image    URL или путь превью-картинки для карточки выдачи.
     * @param float                $boost    Индивидуальный множитель релевантности документа поверх
     *                                       {@see SearchSource::$boost} — например, чтобы закреплённая
     *                                       статья была выше обычных. 1.0 — без изменений.
     */
    public function __construct(
        public string $type,
        public int|string $entityId,
        public string $route,
        public array $params,
        public string $title,
        public string $text,
        public string $keywords = '',
        public ?string $excerpt = null,
        public ?int $date = null,
        public ?string $image = null,
        public float $boost = 1.0,
    ) {
    }
}
