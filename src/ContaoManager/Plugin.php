<?php

namespace Hofff\Contao\Calendarfield\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;


/**
 * Plugin for the Contao Manager.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles( ParserInterface $parser )
    {
        return [
            BundleConfig::create( 'Hofff\Contao\Calendarfield\HofffCalendarfieldBundle' )
                ->setLoadAfter( ['Contao\CoreBundle\ContaoCoreBundle'] ),
        ];
    }
}