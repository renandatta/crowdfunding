<?php

use App\CampaignType;
use Illuminate\Database\Seeder;

class CampaignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampaignType::insert([
            ['name' => 'Kuliner', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'kuliner', 'icon' => 'https://source.unsplash.com/random/800x600'],
            ['name' => 'Jasa', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'jasa', 'icon' => 'https://source.unsplash.com/random/800x600'],
            ['name' => 'Cenderamata', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'cenderamata', 'icon' => 'https://source.unsplash.com/random/800x600'],
            ['name' => 'Seniman', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'seniman', 'icon' => 'https://source.unsplash.com/random/800x600'],
            ['name' => 'Teknologi', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'teknologi', 'icon' => 'https://source.unsplash.com/random/800x600'],
            ['name' => 'Edukasi', 'description' => 'Lorem ipsum sir dolor amet', 'slug' => 'edukasi', 'icon' => 'https://source.unsplash.com/random/800x600'],
        ]);
    }
}
