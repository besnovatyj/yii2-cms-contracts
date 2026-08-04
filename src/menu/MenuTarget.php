<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\menu;

/**
 * Цель для построения пункта меню, объявляемая модулем-провайдером {@see MenuTargetProvider}.
 *
 * Описывает внутренний фронтовый роут (например, раздел/категорию/таксономию) и имя GET-параметра,
 * несущего slug сущности. Модуль меню по этим данным строит готовый URL пункта меню
 * (`frontendUrlManager->createUrl([$route, $slugParam => $slug])`).
 *
 * Нейтральный DTO без зависимостей — живёт в контрактах, чтобы и модуль-провайдер, и модуль меню могли
 * ссылаться на него, не завися друг от друга. Форма намеренно совпадает с {@see \Besnovatyj\Contracts\routing\AliasTarget}:
 * оба канала (алиасы и меню) адресуют цели по slug, но семантика разная (алиас — rewrite URL, меню —
 * навигационный узел с именем и иерархией), поэтому это отдельный контракт, а не переиспользование.
 */
final readonly class MenuTarget
{
    /**
     * @param string $route     Внутренний роут цели. Допускается с ведущим слэшем или без.
     * @param string $label     Человекочитаемая подпись группы целей для выпадающего списка в админке.
     * @param string $slugParam Имя GET-параметра, в который подставляется slug (по умолчанию `slug`).
     */
    public function __construct(
        public string $route,
        public string $label,
        public string $slugParam = 'slug',
    ) {
    }
}
