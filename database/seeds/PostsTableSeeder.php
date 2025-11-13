<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\PostCategory;
use App\User;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $categories = PostCategory::all();

        if ($users->count() > 0 && $categories->count() > 0) {
            $posts = [
                [
                    'name' => '10 Hair Care Tips for Healthy Hair',
                    'content' => 'Maintaining healthy hair requires consistent care and the right products. Here are our top 10 tips for achieving beautiful, healthy hair...',
                    'type' => 'article',
                ],
                [
                    'name' => 'Latest Beauty Trends of 2024',
                    'content' => 'Stay ahead of the curve with these emerging beauty trends that are taking the industry by storm this year...',
                    'type' => 'article',
                ],
                [
                    'name' => 'How to Style Natural Hair',
                    'content' => 'Natural hair is beautiful and versatile. Learn the best techniques for styling and maintaining your natural hair...',
                    'type' => 'guide',
                ],
                [
                    'name' => 'Skincare Routine for Beginners',
                    'content' => 'Starting a skincare routine can be overwhelming. This simple guide will help you establish an effective daily routine...',
                    'type' => 'guide',
                ],
                [
                    'name' => 'Makeup Tips for Dark Skin',
                    'content' => 'Discover the best makeup techniques and products that complement darker skin tones perfectly...',
                    'type' => 'tips',
                ],
            ];

            foreach ($posts as $postData) {
                Post::create([
                    'name' => $postData['name'],
                    'slug' => Str::slug($postData['name']),
                    'content' => $postData['content'],
                    'category_id' => $categories->random()->id,
                    'user_id' => $users->random()->id,
                    'type' => $postData['type'],
                    'status' => 'published',
                ]);
            }
        }
    }
}
