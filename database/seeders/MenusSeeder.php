<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMenu('header_main', 'Header – Main Nav', [
            ['label' => 'Flights', 'url' => '/flights/'],
            ['label' => 'Hotels', 'url' => '/hotels/'],
            ['label' => 'Holiday packages', 'url' => '/holiday-packages/'],
            ['label' => 'Umrah', 'url' => '/religious-tours/', 'children' => [
                ['label' => 'Religious travel overview', 'url' => '/religious-tours/'],
                ['label' => 'Private Umrah', 'url' => '/religious-tours/private-umrah/'],
                ['label' => 'Group Umrah', 'url' => '/religious-tours/group-umrah/'],
                ['label' => 'Private Hajj', 'url' => '/religious-tours/private-hajj/'],
                ['label' => 'Group Hajj', 'url' => '/religious-tours/group-hajj/'],
                ['label' => 'Ziarat journeys', 'url' => '/religious-tours/group-ziarat-iran/'],
            ]],
            ['label' => 'Destinations', 'url' => '/locations/', 'children' => [
                ['label' => 'All destinations', 'url' => '/locations/'],
                ['label' => 'Pakistan', 'url' => '/location/pakistan/'],
                ['label' => 'India', 'url' => '/location/india/'],
                ['label' => 'Nepal', 'url' => '/location/nepal/'],
                ['label' => 'Canada', 'url' => '/location/canada/'],
                ['label' => 'Australia', 'url' => '/location/australia/'],
                ['label' => 'Saudi Arabia', 'url' => '/location/saudi-arabia/'],
            ]],
            ['label' => 'Payment options', 'url' => '/payment-options/'],
            ['label' => 'More', 'url' => '/about/', 'children' => [
                ['label' => 'About Fly Quick', 'url' => '/about/'],
                ['label' => 'Corporate travel', 'url' => '/corporate-travel-australia/'],
                ['label' => 'FAQs', 'url' => '/faqs/'],
                ['label' => 'Contact us', 'url' => '/contact/'],
            ]],
        ]);

        $this->seedMenu('footer_plan', 'Footer – Plan Your Trip', [
            ['label' => 'Flights', 'url' => '/flights/'],
            ['label' => 'Hotels', 'url' => '/hotels/'],
            ['label' => 'Holiday packages', 'url' => '/holiday-packages/'],
            ['label' => 'Destinations', 'url' => '/locations/'],
        ]);

        $this->seedMenu('footer_company', 'Footer – Company Links', [
            ['label' => 'About us', 'url' => '/about/'],
            ['label' => 'Corporate travel', 'url' => '/corporate-travel-australia/'],
            ['label' => 'Religious travel', 'url' => '/religious-tours/'],
            ['label' => 'Payment options', 'url' => '/payment-options/'],
            ['label' => 'FAQs', 'url' => '/faqs/'],
        ]);
    }

    private function seedMenu(string $location, string $name, array $items): void
    {
        $menu = Menu::firstOrCreate(['location' => $location], ['name' => $name]);

        if ($menu->allItems()->exists()) {
            return;
        }

        foreach ($items as $i => $item) {
            $created = $menu->allItems()->create([
                'label'      => $item['label'],
                'url'        => $item['url'],
                'target'     => '_self',
                'sort_order' => $i,
                'is_active'  => true,
            ]);

            foreach ($item['children'] ?? [] as $j => $child) {
                $created->children()->create([
                    'menu_id'    => $menu->id,
                    'label'      => $child['label'],
                    'url'        => $child['url'],
                    'target'     => '_self',
                    'sort_order' => $j,
                    'is_active'  => true,
                ]);
            }
        }
    }
}
