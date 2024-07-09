<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' =>[
                    'placeholder' => 'Nom de l\'article',
                ]
            ])

            ->add('categories', EntityType::class, [
                'label'=> 'Catégories',
                'class' => Categorie::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'autocomplete' => true,
                // En faisant la methode query_builder(), je créer mon constructeur de requete SQL
                'query_builder' => function (CategorieRepository $repo): QueryBuilder{
                    return $repo->createQueryBuilder('c')
                        ->andWhere('c.enable = true')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('content',  TextareaType::class, [
                'label' => 'Contenu',
                'attr' =>[
                    'placeholder' => 'Contenu de l\'article',
                    'rows' => 10,
                ]
                ])

            ->add('enable', CheckboxType::class,[
                'label' => 'Actif',
                'required' => false,
            ]);
         
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
