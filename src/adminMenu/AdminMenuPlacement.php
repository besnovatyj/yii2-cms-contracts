<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\adminMenu;

/**
 * Размещение пункта меню админки: в какую локацию, в какую группу и на какое место.
 *
 * Пункт меню — обычный пункт `NavWidget`, которому модуль в своём `src/config/adminMenu.php` (группа
 * `admin-menu` движка конфигов) добавляет список размещений:
 * ```php
 * [
 *     'label' => 'Модули',
 *     'iconClass' => 'bi bi-bricks me-1',
 *     'url' => ['/Modman/backend/modules/index'],
 *     '_meta' => [
 *         'placements' => [
 *             new AdminMenuPlacement(
 *                 location: AdminMenuLocation::RightSidebar,
 *                 group: 'Service',
 *                 groupIcon: 'bi bi-sliders',
 *                 groupPriority: 100,
 *                 priority: 100,
 *             ),
 *         ],
 *     ],
 * ]
 * ```
 * Пункт встаёт в столько мест, сколько у него размещений.
 *
 * Группа описывается полями размещения: пункты с одинаковым `group` в одной локации собираются в одну
 * раскрывающуюся группу, а её иконка и приоритет берутся из размещения, которое открыло группу первым.
 */
final readonly class AdminMenuPlacement
{
    public const int DEFAULT_PRIORITY = 500;
    public const string DEFAULT_GROUP_ICON = 'bi bi-folder';

    /**
     * @param AdminMenuLocation $location      Локация, в которую встаёт пункт.
     * @param string|null       $group         Заголовок группы; null — пункт встаёт в корень локации.
     * @param string            $groupIcon     CSS-класс иконки группы.
     * @param int               $groupPriority Порядок группы в локации (меньше — выше).
     * @param int               $priority      Порядок пункта внутри группы (меньше — выше).
     */
    public function __construct(
        public AdminMenuLocation $location,
        public ?string $group = null,
        public string $groupIcon = self::DEFAULT_GROUP_ICON,
        public int $groupPriority = self::DEFAULT_PRIORITY,
        public int $priority = self::DEFAULT_PRIORITY,
    ) {
    }
}
