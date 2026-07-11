<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\security;

/**
 * Авторизатор доступа к маршруту — точка, которую зовёт гейт закрытого приложения.
 *
 * Разделяет два элемента архитектуры: ГЕЙТ (deny-by-default фильтр, живёт в ядре и есть всегда) и
 * АВТОРИЗАТОР (решение «можно/нельзя», предоставляется модулем безопасности). Ядро по умолчанию
 * связывает компонент `accessAuthorizer` с реализацией «запретить всё»; модуль `user` перекрывает
 * её RBAC-реализацией. Так закрытие — свойство ядра, а не следствие установки модуля: отсутствие
 * или поломка авторизатора трактуется гейтом как ЗАПРЕТ (fail-closed), а не как проход.
 */
interface AccessAuthorizer
{
    /**
     * Разрешён ли данному пользователю доступ к маршруту.
     *
     * @param string   $route  нормализованный маршрут вида `/{module}/{controller}/{action}`
     * @param array    $params параметры запроса (для RBAC-правил, зависящих от данных)
     * @param int|null $userId id пользователя; null — гость
     * @return bool true — доступ разрешён; false — запрещён (гейт применит denyAccess)
     */
    public function isAllowed(string $route, array $params = [], ?int $userId = null): bool;
}
