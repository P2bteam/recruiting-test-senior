<?php
include_once("CommonDBTrait.php");

class Comment
{
    use CommonDBTrait;

    private ?int $id = null;

    private ?Place $objPlace = null;

    private string $comment = "";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getObjPlace(): ?Place
    {
        return $this->objPlace;
    }

    public function setObjPlace(?Place $objPlace): void
    {
        $this->objPlace = $objPlace;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }
}