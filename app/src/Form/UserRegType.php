<?php

namespace App\Form;

use App\Model\EducationEnum;
use App\Service\Scoring\EducationScoresEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserRegType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank(message: 'Значение не может быть пустым')],
                'label' => 'Имя',
            ])
            ->add('surname', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank(message: 'Значение не может быть пустым')],
                'label' => 'Фамилия',
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Значение не может быть пустым'),
                    new Email(message: 'Значение не является валидным email-адресом')
                ]
            ])
            ->add('phone', TelType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Значение не может быть пустым'),
                    new Regex(
                        '/^\+79\d{9}$/',
                        'Номер телефона не соответствует формату "+79111111111"'
                    )
                ],
                'attr' => ['placeholder' => 'Формат "+79111111111"'],
                'label' => 'Номер телефона',
            ])
            ->add('education', ChoiceType::class, [
                'required' => true,
                'constraints' => [new NotBlank(message: 'Значение не может быть пустым')],
                'choices' => array_flip(EducationEnum::getCases()),
                'label' => 'Образование',
            ])
            ->add('agree', CheckboxType::class, [
                'required' => false,
                'label' => 'Я даю согласие на обработку моих личных данных',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить'
            ])
        ;
    }
}
