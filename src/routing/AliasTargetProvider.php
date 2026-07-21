<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\routing;

/**
 * Модуль объявляет свои алиасуемые цели и доступные для них slug.
 *
 * Реализуется классом Yii-модуля (напр. {@see \Besnovatyj\Page\Module}). Потребитель — модуль
 * управления URL-алиасами: он находит провайдеров через `instanceof AliasTargetProvider` и строит
 * каскад «модуль → базовый путь → slug» в админке. Связанность нулевая: если модуля алиасов нет —
 * контракт никто не вызывает; если модуль его не реализует — он просто не появится в списке целей.
 *
 * Это применение принципа инверсии зависимостей (DIP): и провайдер, и модуль алиасов зависят от данной
 * абстракции, а не друг от друга.
 */
interface AliasTargetProvider
{
    /**
     * Цели этого модуля, которым можно назначить короткий URL.
     *
     * @return AliasTarget[]
     */
    public function aliasTargets(): array;

    /**
     * Доступные slug для заданной цели (для выпадающего списка в админке).
     *
     * @param string $route роут цели (в том же виде, что в {@see AliasTarget::$route})
     * @return array<string,string> карта `slug => подпись` (напр. `'about' => 'О компании'`)
     */
    public function aliasSlugs(string $route): array;
}
