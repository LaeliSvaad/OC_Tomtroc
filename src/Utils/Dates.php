<?php
declare(strict_types=1);

namespace App\Utils;

final class Dates
{
    public static function dateInterval(\DateTime $registrationDate) :string
    {
        $now = new \DateTime();
        $interval = $now->diff($registrationDate);
        if($interval->y != 0)
            return $interval->format("%y ans");
        else if($interval->y === 0 && $interval->m != 0)
            return $interval->format("%m mois");
        else if($interval->y === 0 && $interval->m === 0 && $interval->d != 0)
            return $interval->format("%d jours");
        else
            return $interval->format("%H heures");
    }
    public static function convertDateToMediumFormat(\DateTime $date) : string
    {
        $dateFormatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $today = new \DateTime('today');
        if ($date->format('Y-m-d') !== $today->format('Y-m-d')) {
            $dateFormatter->setPattern('dd.MM HH:mm');
        } else {
            $dateFormatter->setPattern('HH:mm');
        }
        return $dateFormatter->format($date);
    }

    public static function convertDateToSmallFormat(\DateTime $date) : string
    {
        $dateFormatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $today = new \DateTime('today');
        if ($date->format('Y-m-d') !== $today->format('Y-m-d')) {
            $dateFormatter->setPattern('dd.MM');
        } else {
            $dateFormatter->setPattern('HH:mm');
        }
        return $dateFormatter->format($date);
    }
}
