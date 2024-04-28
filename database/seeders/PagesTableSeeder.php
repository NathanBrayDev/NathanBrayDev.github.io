<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Homepage',
                'slug' => '/',
                'layout' => 'default',
                'blocks' => '[{"data": {"image": null, "content": "<p>Homepage</p>"}, "type": "default-page"}]',
                'parent_id' => NULL,
                'created_at' => '2023-11-21 16:13:30',
                'updated_at' => '2023-11-21 17:10:06',
                'active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'News',
                'slug' => 'news',
                'layout' => 'default',
                'blocks' => '[{"data": {"image": null, "content": "<p></p>"}, "type": "default-page"}]',
                'parent_id' => NULL,
                'created_at' => '2023-11-21 16:13:54',
                'updated_at' => '2023-11-21 16:13:54',
                'active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Events',
                'slug' => 'events',
                'layout' => 'default',
                'blocks' => '[{"data": {"image": null, "content": "<p>Events</p>"}, "type": "default-page"}]',
                'parent_id' => NULL,
                'created_at' => '2023-11-21 16:14:13',
                'updated_at' => '2023-11-21 17:11:18',
                'active' => 1,
            ),
        ));
        
        
    }
}