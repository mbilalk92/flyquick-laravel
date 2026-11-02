<?php

namespace App\Filament\Resources\ContactEnquiryResource\Pages;

use App\Filament\Resources\ContactEnquiryResource;
use App\Models\ContactEnquiry;
use Filament\Resources\Pages\ViewRecord;

class ViewContactEnquiry extends ViewRecord
{
    protected static string $resource = ContactEnquiryResource::class;

    protected function afterMount(): void
    {
        if (!$this->record->is_read) {
            $this->record->markAsRead();
        }
    }
}
