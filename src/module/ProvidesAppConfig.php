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
 * и `accessAuthorizer` для backend/rest, но не для frontend. Компилятор раскладывает вклады по
 * per-app артефактам, которые конфиг соответствующего приложения подмешивает при сборке.
 *
 * Формат: `['<appId>' => ['components' => [...], 'allowActions' => [...]], ...]`.
 *
 * БЕЗОПАСНОСТЬ: компилятор берёт ТОЛЬКО ключи `components` и `allowActions`. Любые ключи поведений
 * (`as*`, в частности `as access`) игнорируются — гейт доступа принадлежит ядру, модуль не может его
 * ни заменить, ни снять. Модуль лишь ДОПОЛНЯЕТ whitelist (`allowActions`) и ПЕРЕОПРЕДЕЛЯЕТ компоненты
 * (`identityClass`, `accessAuthorizer`, `authManager`, …).
 */
interface ProvidesAppConfig
{
    /**
     * @return array<string, array{components?: array<string, array>, allowActions?: string[]}>
     *   appId => вклад для этого приложения
     */
    public static function appConfig(): array;
}
