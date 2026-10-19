<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\block;

/**
 * Поставщик данных для шаблона типа блока: то, чего нет в полях блока, но нужно для вывода.
 *
 * Пример: блок «витрина спектаклей» хранит заголовок и количество, а сами спектакли берёт поставщик
 * из readModel своего модуля. Кэшировать выборку — забота поставщика: модуль блоков готовый HTML
 * таких блоков не кэширует, потому что данные у них живые.
 *
 * Класс указывается в {@see BlockType::$dataProvider} и создаётся DI-контейнером при выводе блока,
 * поэтому зависимости можно получать через конструктор.
 */
interface BlockDataProvider
{
    /**
     * Переменные для шаблона типа.
     *
     * @param array<string, mixed> $data данные блока, уже приведённые к схеме типа
     * @return array<string, mixed> имя переменной шаблона => значение; не должны перекрывать `data`
     */
    public function provide(array $data): array;
}
