<?php

declare(strict_types=1);

namespace Hofff\CalendarfieldBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Hofff\CalendarfieldBundle\HofffCalendarfieldBundle;

class Plugin implements BundlePluginInterface
{
    /** {@inheritdoc} */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(HofffCalendarfieldBundle::class)
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle']),
        ];
    }
}
