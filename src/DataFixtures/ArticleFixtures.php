<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Faker\Factory;
use Faker\Generator;



class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        // crreer 3 categories fake
        for($i=1;$i <= 12;$i++){
            $category = new Category();
            $category-> setTitle($faker->sentence());
            $category-> setDescription($faker->paragraph());
            
            $manager->persist($category);
            // cree de 4 a 6 articles

            for($j=1; $j <= mt_rand(5,8); $j++){
                $article = new Article();

                $content = '<p>';
                $content .= join($faker->paragraphs(5), '</p><p>');
                $content .= '</p>';

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category)
                        ->setAuthor($faker->name);
                        

                $manager->persist($article);

                // commentaires de l article
                for($j=1; $j <= mt_rand(1,10); $j++){
                    $comment = new Comment();

                    $content ='<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                    $days = (new \DateTime())->diff($article->getCreatedAt())->days;

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                            ->setArticle($article);

                    $manager->persist($comment);
                }   
            }
        }    
        $manager->flush();
    }
}
