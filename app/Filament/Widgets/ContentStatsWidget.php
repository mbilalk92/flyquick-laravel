<?php

namespace App\Filament\Widgets;

use App\Models\ContactEnquiry;
use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Contact enquiries and published pages are the only "traffic" numbers we
 * actually have in this database — real page-view/visit analytics live in
 * GA4 (see config/analytics.php), not here, so this widget doesn't fake
 * numbers for that.
 */
class ContentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $unread = ContactEnquiry::where('is_read', false)->count();

        return [
            Stat::make('Contact Enquiries', ContactEnquiry::count())
                ->description($unread > 0 ? "{$unread} unread" : 'All read')
                ->descriptionIcon($unread > 0 ? 'heroicon-m-envelope' : 'heroicon-m-check-circle')
                ->color($unread > 0 ? 'warning' : 'success'),

            Stat::make('Published Pages', Page::where('is_published', true)->count())
                ->description(Page::count() . ' total (incl. drafts)')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
}
