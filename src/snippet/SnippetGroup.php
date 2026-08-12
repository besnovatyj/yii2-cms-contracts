<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\snippet;

/**
 * Категория сниппетов, объявляемая провайдером {@see SnippetProvider}.
 *
 * Один уровень группировки для пикера редактора (например «Контакты», «Реквизиты», «Баннеры»).
 * Нейтральный DTO без зависимостей — живёт в контрактах, чтобы провайдеры и модуль-агрегатор
 * ссылались на него, не завися друг от друга. Иерархия намеренно плоская (группа → сниппеты):
 * этого достаточно для тулбара, а глубже усложнит UX выбора.
 */
final readonly class SnippetGroup
{
    /**
     * @param string    $id    Стабильный идентификатор группы (уникален в рамках дерева).
     * @param string    $label Человекочитаемая подпись категории в пикере.
     * @param Snippet[] $items Сниппеты группы в порядке отображения.
     * @param int       $sort  Порядок группы среди других (меньше — выше).
     */
    public function __construct(
        public string $id,
        public string $label,
        public array $items = [],
        public int $sort = 0,
    ) {
    }
}
