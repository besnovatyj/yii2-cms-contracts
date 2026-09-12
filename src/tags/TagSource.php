<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\tags;

/**
 * Вид контента, к которому модуль-провайдер {@see TaggableProvider} привязывает теги.
 *
 * На фронте — вкладка-фасет страницы тега («Статьи 12 · Галереи 3»), в админке — подпись в
 * списке «где используется». Нейтральный DTO без зависимостей: живёт в контрактах, чтобы модуль
 * тегов и контентные модули ссылались на него, не завися друг от друга.
 */
final readonly class TagSource
{
    /**
     * @param string      $type  Стабильный ключ `<модуль>.<сущность>` (`blog.post`). ПОПАДАЕТ В БАЗУ
     *                           (колонка `entity_type` связей) и в query-параметр `type` страницы тега,
     *                           поэтому менять его после запуска нельзя.
     * @param string      $label Подпись для фасета и админки («Статьи блога»).
     * @param string|null $icon  CSS-класс иконки фасета (`bi bi-newspaper`); null — без иконки.
     */
    public function __construct(
        public string $type,
        public string $label,
        public ?string $icon = null,
    ) {
    }
}
