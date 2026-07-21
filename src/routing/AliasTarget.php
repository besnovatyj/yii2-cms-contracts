<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\routing;

/**
 * Алиасуемая цель маршрутизации, объявляемая модулем-провайдером {@see AliasTargetProvider}.
 *
 * Описывает внутренний фронтовый роут, которому админ может назначить короткий URL, и имя параметра,
 * несущего slug. Нейтральный DTO без зависимостей — живёт в контрактах, чтобы и модуль-провайдер
 * (напр. Page), и модуль управления алиасами могли ссылаться на него, не завися друг от друга.
 */
final readonly class AliasTarget
{
    /**
     * @param string $route     Внутренний роут цели. Допускается с ведущим слэшем или без —
     *                          потребитель нормализует (напр. `/Page/page/view` ↔ `Page/page/view`).
     * @param string $label     Человекочитаемая подпись цели для выпадающего списка в админке.
     * @param string $slugParam Имя GET-параметра, в который подставляется slug (по умолчанию `slug`).
     */
    public function __construct(
        public string $route,
        public string $label,
        public string $slugParam = 'slug',
    ) {
    }
}
