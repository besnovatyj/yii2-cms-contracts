<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\module;

/**
 * Модуль вносит конфигурацию, специфичную для конкретного приложения (app-backend, app-rest, …).
 *
 * В отличие от {@see ProvidesComponents} (глобальный вклад в common, одинаковый для всех приложений),
 * этот контракт нужен, когда компонент/настройка зависит от приложения: например, `user.identityClass`
 * и `accessAuthorizer` для backend/rest, но не для frontend.
 *
 * Формат — ЧАСТИЧНОЕ ДЕРЕВО конфига приложения (ключи 1:1 с Yii-конфигом), которое конфиг приложения
 * подмешивает через `ArrayHelper::merge`:
 * ```php
 * ['app-backend' => [
 *     'components' => ['user' => ['identityClass' => ...], 'accessAuthorizer' => [...]],
 *     'as access'  => ['allowActions' => ['User/auth/login', 'User/auth/logout']],
 * ]]
 * ```
 *
 * БЕЗОПАСНОСТЬ: компилятор пропускает вклад через allowlist путей-ключей (единая политика modman).
 * Сейчас разрешены `components`, `params` и `as access.allowActions`. В частности `as access.class`
 * (сам гейт), его `rules`/`denyCallback` — модулю НЕДОСТУПНЫ и вырезаются: гейт принадлежит ядру,
 * модуль может лишь ДОПОЛНИТЬ whitelist и ПЕРЕОПРЕДЕЛИТЬ компоненты, но не подменить/снять замок.
 * Расширение полномочий модулей = расширение этого allowlist в одном месте.
 */
interface ProvidesAppConfig
{
    /**
     * @return array<string, array> appId => частичное дерево конфига приложения (см. описание контракта)
     */
    public static function appConfig(): array;
}
