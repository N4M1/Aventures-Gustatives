<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'alexadmin@gmail.com',
            'roles' => ['ROLE_ADMIN'],
            'pseudo' => 'alecs'
        ]);
        UserFactory::createOne([
            'email' => 'alex@gmail.com',
            'roles' => ['ROLE_USER'],
            'pseudo' => 'alecsadmin'
        ]);
        UserFactory::createMany(10);

        ArticleFactory::createOne([
            'title' => 'Diirrnj huedhuze zudhzed izedi',
            'categorie' => 'Plat',
            'description' => 'Eijnerfeuh ifiuefiefiufuifnvehufn iofjerifenfioe efeozjfoei',
            'creationDate' => new \DateTimeImmutable(),
            'imageFile' => 'pathfile',
            'idUser' =>  UserFactory::random()
        ]);

        ArticleFactory::createMany(5, function (){
            return [
                'idUser' =>  UserFactory::random()
            ];
        });

        $manager->flush();
    }
}
