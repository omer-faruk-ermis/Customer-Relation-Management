<?php

namespace App\Filters\SmsKimlikLog;

use App\Helpers\QueryBuilder;

class LogSubject
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonWanted', function ($reasonWantedQuery) use ($value) {
            $reasonWantedQuery->whereLike(QueryBuilder::collate('ifade'), $value);
        }); //TODO kontrol et ön yüzdeki son halini sor. İFADENİN İD SİNE GÖRE KONTROL ET LIKE İŞLEMİNE GEREK YOK.
    }
}
