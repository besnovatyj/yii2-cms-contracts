<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\snippet;

/**
 * Готовый кусок HTML/текста, вставляемый в контент WYSIWYG-редактора «как есть» (edit-time).
 *
 * Нейтральный DTO без зависимостей — живёт в контрактах, чтобы и модуль-провайдер
 * {@see SnippetProvider}, и модуль-агрегатор сниппетов могли ссылаться на него, не завися друг
 * от друга (DIP). В отличие от шорткода {@see \Besnovatyj\Contracts\shortcode\ShortcodeTextResolver}
 * (render-time плейсхолдер `%name%`), сниппет — это заранее заготовленная разметка, которую автор
 * выбирает в тулбаре и вставляет буквально; её тело затем может содержать шорткоды и пройти их
 * резолвинг уже на рендере фронта.
 */
final readonly class Snippet
{
    /**
     * @param string      $id       Стабильный идентификатор сниппета (уникален в рамках дерева).
     * @param string      $title    Человекочитаемая подпись для списка/поиска в пикере.
     * @param string      $html     Тело, вставляемое в контент редактора «как есть».
     * @param string|null $preview  HTML/текст превью для пикера. null — превью строится из {@see $html}.
     * @param string[]    $keywords Доп. ключевые слова для поиска (помимо {@see $title}).
     */
    public function __construct(
        public string $id,
        public string $title,
        public string $html,
        public ?string $preview = null,
        public array $keywords = [],
    ) {
    }
}
