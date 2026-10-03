<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\module;

/**
 * Ядро контракта модуля, управляемого системой.
 *
 * Методы намеренно СТАТИЧЕСКИЕ: discovery читает метаданные модуля, не инстанцируя Yii-модуль
 * (и, следовательно, не запуская его {@see \yii\base\Module::init()} с побочными эффектами).
 * Наличие возможности проверяется через `class_implements()`/`instanceof`, а не через `method_exists()`.
 *
 * Версии в контракте нет: версия модуля — git-тег (или коммит), по которому composer установил пакет;
 * её определяет менеджер модулей из метаданных composer.
 *
 * Дополнительные возможности модуля объявляются реализацией capability-интерфейсов
 * {@see ProvidesComponents}, {@see ProvidesMigrations} и т.д. — каждый модуль реализует ровно то,
 * что он действительно предоставляет.
 */
interface DeclaresModule
{
    /**
     * Стабильный идентификатор модуля (ключ в конфигурации Yii `modules`).
     * Должен совпадать с `extra.moduleId` в composer.json пакета.
     */
    public static function moduleId(): string;

    /**
     * Базовая конфигурация Yii-модуля: ['id' => ..., 'params' => [...], ...].
     * НЕ содержит 'class' — его добавляет `config/common.php` модуля при регистрации.
     */
    public static function moduleConfig(): array;

    /**
     * Можно ли управлять модулем (устанавливать/удалять/обновлять) через менеджер.
     * Системные модули возвращают false и не могут быть удалены.
     */
    public static function isEditable(): bool;
}
