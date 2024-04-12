<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'blog_article')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

     #[ORM\Column(type: Types::STRING)]
    private ?string $title;

     #[ORM\Column(type: Types::STRING)]
    private ?string $title2;
     #[ORM\Column(type: Types::STRING)]
    private ?string $title3;

    #[ORM\Column(type: Types::STRING)]
    private ?string $author;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private \DateTime $date;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('title', new Assert\NotBlank());
        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'title',
            new Assert\Length(['min' => 10, 'minMessage' => "Votre nom d'article est tres court!"])
        );
        $metadata->addGetterConstraint('passwordSafe', new Assert\IsTrue([
            'message' => 'Invaluable',
        ]));
    }

    public function isPasswordSafe(): bool
    {
//        dd();
        return $this->title != $this->content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
}