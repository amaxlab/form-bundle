AmaxlabFormBundle
==============

AmaxlabFormBundle provides some useful form types for Symfony2 framework

Install
---------

### 0. Add to composer.json

    composer require amaxlab/form-bundle

### 1. Add bundle to AppKernel.php

    $bundles = array(
        ...
        new Amaxlab\Bundle\FormBundle\AmaxlabFormBundle(),
    );
    
### 2. Configure

Create new recaptcha for you domain in https://www.google.com/recaptcha/intro/index.html

Add this keys to config.yml:

    amaxlab_form:
        recaptcha2:
            public_key: 6LfaoQ4TAAAAAOdnLoFZIjBayGa5zUyUOOeNe3y4
            private_key: 6LfaoQ4TAAAAAJvOlPjYNgLUJMfNWllKR7zfiJb7


Form Types
----------------

### 1. select_or_add

Allow select from entity from standart select or add a new Entity throw attached form

### 2. amaxlab_recaptcha2

Add to you form new field (probably not mapped to entity)
    
    $form
        ->add('recaptcha', 'amaxlab_recaptcha2', array(
            'mapped' => false,
        ));
        
Now form will not passed validation if recaptcha is invalid.
