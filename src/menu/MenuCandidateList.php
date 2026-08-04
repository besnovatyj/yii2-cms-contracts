<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\menu;

/**
 * Хелпер построения карты кандидатов `slug => подпись` из узлов nested-sets дерева для
 * {@see MenuTargetProvider::menuCandidates()}.
 *
 * Узлы группируются по дереву и упорядочиваются в DFS-порядке `(tree, lft)`, а подпись получает
 * отступ по глубине `depth` — так в плоском выпадающем списке видна иерархия. Сортировка по одному
 * `lft` для леса деревьев (несколько корней) перемешала бы узлы разных деревьев между собой, поэтому
 * ключ сортировки — именно пара `(tree, lft)`, совпадающая с индексом `['tree','lft','rgt']`.
 *
 * Узлы должны предоставлять публичные свойства `tree`, `lft`, `depth`, `slug`, `name` (напр. любой
 * наследник Node из tree-manager). Хелпер намеренно duck-typed и не зависит от tree-manager, чтобы
 * жить в контрактах.
 */
final class MenuCandidateList
{
    /**
     * @param iterable<object> $nodes узлы дерева со свойствами tree/lft/depth/slug/name
     * @param string $indent строка отступа, повторяемая по глубине узла
     * @return array<string,string> карта `slug => подпись` в DFS-порядке с отступами
     */
    public static function fromNestedSet(iterable $nodes, string $indent = '— '): array
    {
        $list = is_array($nodes) ? $nodes : iterator_to_array($nodes);

        usort($list, static fn(object $a, object $b): int =>
            [(int)$a->tree, (int)$a->lft] <=> [(int)$b->tree, (int)$b->lft]);

        $map = [];
        foreach ($list as $node) {
            $depth = max(0, (int)$node->depth);
            $map[(string)$node->slug] = str_repeat($indent, $depth) . $node->name;
        }
        return $map;
    }
}
