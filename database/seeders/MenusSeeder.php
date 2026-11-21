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
            ['label' => 'Umrah', 'url' => '/religious-tours/'],
            ['label' => 'Destinations', 'url' => '/locations/'],
            ['label' => 'Payment options', 'url' => '/payment-options/'],
            ['label' => 'More', 'url' => '/about/'],
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
            $menu->allItems()->create([
                'label'      => $item['label'],
                'url'        => $item['url'],
                'target'     => '_self',
                'sort_order' => $i,
                'is_active'  => true,
            ]);
        }
    }
}
