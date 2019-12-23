<?php

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1= Category::create([
            'name' => 'News'
        ]);
        $category2= Category::create([
            'name' => 'Marketing'
        ]);
        $category3= Category::create([
            'name' => 'Partnership'
        ]);
        $category4= Category::create([
            'name' => 'Design'
        ]);


        $author1=App\User::create([
            'name' =>  'Arif Ahmed',
            'email' => 'Arif@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $author2=App\User::create([
            'name' =>  'Azam Pasha',
            'email' => 'azampasha@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $author3=App\User::create([
            'name' =>  'Rizwana Jameel',
            'email' => 'rizjam@gmail.com',
            'password' => Hash::make('password'),
        ]);


        $tag1 = Tag::create([
            'name' => 'Job'
        ]);

        $tag2 = Tag::create([
            'name' => 'Customers'
        ]);

        $tag3 = Tag::create([
            'name' => 'record'
        ]);


        $post1 = $author1->posts()->create([
            'title' => 'We relocated our office to a new designed garage',
            'description' => 'Lorem ipsum dolor sit amet consectetur',
            'content' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, deserunt?',
            'image' => 'posts/1.jpg',
            'category_id' => $category1->id
        ]);
        $post2 =  $author2->posts()->create([
            'title' => 'Top 5 brilliant content marketing strategies',
            'description' => 'Lorem ipsum dolor sit amet consectetur',
            'content' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, deserunt?',
            'image' => 'posts/2.jpg',
            'category_id' => $category2->id
        ]);
        $post3 =  $author3->posts()->create([
            'title' => 'Best practices for minimalist design with example',
            'description' => 'Lorem ipsum dolor sit amet consectetur',
            'content' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, deserunt?',
            'image' => 'posts/3.jpg',
            'category_id' => $category3->id
        ]);
        $post4 =  $author3->posts()->create([
            'title' => 'Best practices for minimalist design with example',
            'description' => 'Lorem ipsum dolor sit amet consectetur',
            'content' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, deserunt?',
            'image' => 'posts/4.jpg',
            'category_id' => $category4->id
        ]);

        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag2->id, $tag3->id]);
        $post3->tags()->attach([$tag1->id, $tag3->id]);
        $post2->tags()->attach([$tag2->id, $tag1->id]);
    }
}
