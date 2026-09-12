<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\tags;

/**
 * Карточка записи на странице тега — то, что модуль-провайдер {@see TaggableProvider} отдаёт
 * модулю тегов вместо самой сущности.
 *
 * Ссылка хранится как `route` + `params`, а не готовым URL — по той же причине, что и в
 * {@see \Besnovatyj\Contracts\search\SearchDocument}: короткий адрес сущности может измениться
 * в модуле алиасов, `Url::to()` строится в момент вывода.
 */
final readonly class TaggedItem
{
    /**
     * @param string               $type     Ключ источника из {@see TagSource::$type}.
     * @param int                  $entityId Первичный ключ записи в таблице её модуля.
     * @param string               $route    Внутренний роут фронтенда (`/Blog/post/view`).
     * @param array<string, mixed> $params   Параметры роута (`['id' => 42]`).
     * @param string               $title    Заголовок — выводится ссылкой.
     * @param string|null          $excerpt  Анонс; допускается сырой текст без HTML.
     * @param int|null             $date     Дата публикации, Unix-timestamp.
     * @param string|null          $image    URL превью для карточки.
     */
    public function __construct(
        public string $type,
        public int $entityId,
        public string $route,
        public array $params,
        public string $title,
        public ?string $excerpt = null,
        public ?int $date = null,
        public ?string $image = null,
    ) {
    }
}
