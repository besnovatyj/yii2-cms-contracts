<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\dashboard;

use InvalidArgumentException;

/**
 * Неизменяемое описание одной плитки главной панели админки.
 *
 * Это ЧИСТЫЕ данные (без замыканий и без зависимости от Yii): дескриптор безопасно сериализуется
 * компилятором модулей в var_export-артефакт и восстанавливается в рантайме {@see fromArray()}.
 * Динамическое содержимое плитки (число, кнопка) даёт виджет {@see $tileClass}, инстанцируемый
 * дашбордом только при фактическом показе плитки.
 *
 * Разделение ответственности:
 *  - дескриптор — статические метаданные (заголовок, иконка, дефолтная включённость/порядок, доступ);
 *  - {@see $tileClass} — Yii-виджет (`yii\base\Widget`), рендерящий ТОЛЬКО тело карточки; общий
 *    «каркас» карточки рисует дашборд, поэтому плитки выглядят единообразно, а модуль пишет минимум.
 */
final readonly class DashboardWidgetDescriptor
{
    /**
     * @param string      $id               глобально уникальный идентификатор плитки (напр. 'Catalog.productsCount');
     *                                       рекомендуемый формат — `<ModuleId>.<name>`
     * @param string      $title            заголовок карточки
     * @param string      $tileClass        FQCN Yii-виджета (`yii\base\Widget`), рендерящего тело плитки
     * @param string      $iconClass        CSS-класс иконки (напр. 'bi bi-box-seam')
     * @param bool        $enabledByDefault показывать ли плитку, пока пользователь не настроил раскладку
     * @param int         $priority         дефолтный порядок (меньше — выше/левее); используется, пока нет ручной сортировки
     * @param string|null $permission       имя RBAC-разрешения; плитка видна, только если `Yii::$app->user->can()` истинно (null — без ограничения)
     * @param string      $size             подсказка ширины плитки в сетке Bootstrap: 'sm'|'md'|'lg'
     */
    public function __construct(
        public string  $id,
        public string  $title,
        public string  $tileClass,
        public string  $iconClass = 'bi bi-grid-1x2',
        public bool    $enabledByDefault = true,
        public int     $priority = 500,
        public ?string $permission = null,
        public string  $size = 'md',
    ) {
        if ($id === '') {
            throw new InvalidArgumentException('DashboardWidgetDescriptor: id не может быть пустым.');
        }
        if ($tileClass === '') {
            throw new InvalidArgumentException("DashboardWidgetDescriptor '{$id}': tileClass не может быть пустым.");
        }
    }

    /**
     * Плоское представление для var_export-артефакта. Ключи стабильны — совместимы с {@see fromArray()}.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tileClass' => $this->tileClass,
            'iconClass' => $this->iconClass,
            'enabledByDefault' => $this->enabledByDefault,
            'priority' => $this->priority,
            'permission' => $this->permission,
            'size' => $this->size,
        ];
    }

    /**
     * Восстанавливает дескриптор из плоского представления артефакта.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string)($data['id'] ?? ''),
            title: (string)($data['title'] ?? ''),
            tileClass: (string)($data['tileClass'] ?? ''),
            iconClass: (string)($data['iconClass'] ?? 'bi bi-grid-1x2'),
            enabledByDefault: (bool)($data['enabledByDefault'] ?? true),
            priority: (int)($data['priority'] ?? 500),
            permission: isset($data['permission']) ? (string)$data['permission'] : null,
            size: (string)($data['size'] ?? 'md'),
        );
    }
}
