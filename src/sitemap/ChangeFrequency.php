<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

declare(strict_types=1);

namespace Besnovatyj\Contracts\sitemap;

/**
 * Предполагаемая частота изменения адреса — значение элемента `<changefreq>` протокола sitemaps.org.
 *
 * Перечисление, а не строковые константы: набор значений закрыт самим протоколом, и опечатка
 * («weekley») делает элемент невалидным молча — краулер просто игнорирует карту целиком.
 *
 * Значение — подсказка, а не обещание: поисковые системы обходятся с ним по своему усмотрению и
 * ориентируются в первую очередь на `<lastmod>`. Поэтому ставить `Always`/`Hourly` разделу, который
 * меняется раз в месяц, бессмысленно — это не ускоряет переобход, но снижает доверие к карте.
 */
enum ChangeFrequency: string
{
    case Always = 'always';
    case Hourly = 'hourly';
    case Daily = 'daily';
    case Weekly = 'weekly';
    case Monthly = 'monthly';
    case Yearly = 'yearly';
    case Never = 'never';

    /**
     * Разбор значения, пришедшего строкой (настройки администратора, артефакт сборки).
     *
     * Неизвестное или пустое значение — не ошибка: администратор мог опечататься в поле настроек,
     * и карта сайта из-за этого падать не должна. Возвращается `null`, потребитель подставляет
     * своё умолчание.
     */
    public static function parse(?string $value): ?self
    {
        $value = trim((string)$value);

        // Именно `strtolower`, а не `mb_strtolower`: значения протокола — латиница, и тянуть ради
        // них ext-mbstring в пакет контрактов, у которого нет ни одной зависимости, незачем.
        return $value === '' ? null : self::tryFrom(strtolower($value));
    }
}
