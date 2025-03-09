<?php

namespace App\Model;

class Book extends BaseProduct
{
    private string $author;
    private string $isbn;
    private int $pages;
    private string $genre;

    public function __construct(int $id, string $name, Brand $brand, int $price, string $author, string $isbn, int $pages, string $genre)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setBrand($brand);
        $this->setAuthor($author);
        $this->setIsbn($isbn);
        $this->setPages($pages);
        $this->setGenre($genre);
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): Book
    {
        $this->author = $author;
        return $this;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function setPages(int $pages): Book
    {
        $this->pages = $pages;
        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): Book
    {
        $this->genre = $genre;
        return $this;
    }
} 