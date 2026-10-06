<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\upload;

/**
 * Источник превью, объявляемый модулем-провайдером {@see ThumbnailSourceProvider}.
 *
 * Описывает одну пару «модель + атрибут файла», для которой настроены профили превью.
 * Нейтральный DTO без зависимостей — живёт в контрактах, чтобы и модуль-провайдер,
 * и модуль загрузок могли ссылаться на него, не завися друг от друга.
 */
final readonly class ThumbnailSource
{
    /**
     * @param string $modelClass FQCN ActiveRecord-модели, к которой подключён behavior загрузки
     *                           с профилями превью.
     * @param string $attribute  Имя атрибута файла в модели (напр. `file`, `photo`).
     * @param string $label      Человекочитаемая подпись для админки (напр. «Изображения статей»).
     */
    public function __construct(
        public string $modelClass,
        public string $attribute,
        public string $label,
    ) {
    }

    /**
     * Стабильный ключ источника для форм и сравнения: `<класс модели>::<атрибут>`.
     */
    public function key(): string
    {
        return $this->modelClass . '::' . $this->attribute;
    }
}
