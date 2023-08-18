<?php 
namespace Viewpoint\ThemeBundle\Data;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData {

    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 30, min: 2),
        ])
    ]
    public ?string $firstname = null;

    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 30, min: 2),
        ])
    ]
    public ?string $lastname = null;

    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Email(),
            
        ])
    ]
    public ?string $email = null;

    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 100, min: 4),
            
        ])
    ]
    public ?string $object = null;

    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 1000, min: 25), 
        ])
    ]
    public ?string $message = null;
}
