## KnpULoremIpsumBundle - Happy "Lorem Ipsum" bundle from screencast

This is an ed project and it's not maintained.

This bundle adds features for generating *Lorem ipsum* like "fake text" 
(i.e., words, sentences and paragraphs) into your Symfony applications, 
but with a little bit more joy since the words used by default 
have positive connotations.    

Also, it provides an API endpoint to obtain this kind of text. 
The list of words can be changed using a plugin system 
with classes implementing specific interface. 

The bundle was created by following a set of step by step instructions
presented in a screencast on [Creating a Reusable (& Amazing) Symfony Bundle](https://symfonycasts.com/screencast/symfony-bundle)
by Ryan Weaver.
 
Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require  voltel/knpu-lorem-ipsum-bundle 
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require  voltel/knpu-lorem-ipsum-bundle 
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    KnpU\LoremIpsumBundle\KnpULoremIpsumBundle::class => ['all' => true],
];
```

Usage
============

This bundle provides a single service for generating fake text, which
you can autowire by using the `KnpUIpsum` type-hint:

```php
// src/Controller/SomeController.php

use KnpU\LoremIpsumBundle\KnpUIpsum;
// ...

class SomeController
{
    public function index(KnpUIpsum $knpUIpsum)
    {
        $fakeText = $knpUIpsum->getParagraphs();

        // ...
    }
}
```

You can also access this service directly using the id
`knpu_lorem_ipsum.knpu_ipsum`.

Configuration
=============
A few parts of the generated text can be configured directly by
creating a new `config/packages/knpu_lorem_ipsum.yaml` file. The
default values are:

```yaml
# config/packages/knpu_lorem_ipsum.yaml
knpu_lorem_ipsum:

    # Whether you believe in unicorns or not
    unicorns_are_real:    true

    # Min count of times the word "shunshine" should appear in a paragraph.
    min_sunshine:         3
```

Extending the Word List
=======================

If you're feeling *especially* creative and excited, you can add 
your *own* words to the word generator!

To do that, create a class that implements `WordProviderInterface`:

```php
namespace App\Service;

use KnpU\LoremIpsumBundle\WordProviderInterface;

class CustomWordProvider implements WordProviderInterface
{
    public function getWordList(): array
    {
        return [
            'beach',
            'sunshine', 
            'happy'
        ];
    }
}
```

And... that's it! If you're using the standard service configuration,
your new class will automatically be registered as a service and used
by the system. If you are not, you will need to register this class
as a service and tag it with `knpu_ipsum_word_provider`.

Contributing
============
The following text was originally here in the screencast:

    Of course, open source is fueled by everyone's ability to give just a little bit
    of their time for the greater good. If you'd like to see a feature or add some of
    your *own* happy words, awesome! You can request it - but creating a pull request
    is an even better way to get things done.
    
    Either way, please feel comfortable submitting issues or pull requests: all contributions
    and questions are warmly appreciated :).


**But be aware that this is an ed project and it's not maintained.**
