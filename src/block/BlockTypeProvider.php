<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\block;

/**
 * Модуль поставляет типы блоков для своих сущностей: «витрина спектаклей», «последние посты» и т.п.
 *
 * Реализуется классом Yii-модуля. Потребитель — модуль блоков: в админке он находит провайдеров
 * перебором модулей по контракту, а при выводе блока обращается к модулю напрямую по id.
 *
 * Полный id типа модуля — `{moduleId}:{id}`, где `id` — {@see BlockType::$id} из этого списка. Префикс
 * ставит модуль блоков, поэтому провайдер его не пишет. Префикс избавляет от столкновений с типами
 * темы и других модулей и позволяет при выводе найти модуль-владельца без перебора всех модулей.
 *
 * Связанность нулевая: нет модуля блоков — контракт никто не вызывает; модуль его не реализует —
 * его типов просто нет в списке. Инверсия зависимостей (DIP), как у
 * {@see \Besnovatyj\Contracts\menu\MenuTargetProvider} и {@see \Besnovatyj\Contracts\snippet\SnippetProvider}.
 */
interface BlockTypeProvider
{
    /**
     * Типы блоков этого модуля.
     *
     * @return array<string, BlockType> ключ — {@see BlockType::$id}
     */
    public function blockTypes(): array;
}
