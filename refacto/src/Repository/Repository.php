<?php

namespace Repository;

use Comment;
use DateTime;
use Place;
use User;

class Repository
{
    private string $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * Fake appel à la DB pour le test
     *
     * @param int $id
     * @return Comment|User|Place|null
     */
    public function find(int $id): ?object
    {
        $returnValue = null;
        $objBd = json_decode(file_get_contents(__DIR__ . "/db.json"), false, 512, JSON_THROW_ON_ERROR);
        if ($this->className === Comment::class) {
            foreach ($objBd->comments as $obj) {
                if ($id === $obj->id) {
                    $returnValue = new Comment();
                    $returnValue->setComment($obj->comment);
                    $returnValue->setId($obj->id);
                    $objRepoPlace = new Repository(Place::class);
                    $returnValue->setObjPlace($objRepoPlace->find($obj->place));
                    $this->addCommonTrait($returnValue, $obj);
                    break;
                }
            }
        } elseif ($this->className === User::class) {
            foreach ($objBd->users as $obj) {
                if ($id === $obj->id) {
                    $returnValue = new User();
                    $returnValue->setId($obj->id);
                    $returnValue->setName($obj->name);
                    $this->addCommonTrait($returnValue, $obj);
                    break;
                }
            }
        } elseif ($this->className === Place::class) {
            foreach ($objBd->places as $obj) {
                if ($id === $obj->id) {
                    $returnValue = new Place();
                    $returnValue->setId($obj->id);
                    $returnValue->setName($obj->name);
                    $this->addCommonTrait($returnValue, $obj);
                    break;
                }
            }
        }

        return $returnValue;
    }

    /**
     * @param Comment|User|Place $obj
     * @return bool
     * @throws \JsonException
     */
    public function insert($obj): bool
    {
        $objBd = json_decode(file_get_contents(__DIR__ . "/db.json"), false, 512, JSON_THROW_ON_ERROR);
        if ($this->className === Comment::class) {
            $objBd->comments[] = [
                "id" => count($objBd->comments) + 1,
                "comment" => $obj->getComment(),
                "place" => $obj->getObjPlace()->getId(),
                "createdAt" => $obj->getCreatedAt()->format('Y-m-d H:i:s'),
                "createdBy" => $obj->getCreatedBy() === null ? null : $obj->getCreatedBy()->getId(),
                "updatedAt" => $obj->getUpdatedAt() === null ? null : $obj->getUpdatedAt()->format('Y-m-d H:i:s'),
                "updatedBy" => $obj->getUpdatedBy() === null ? null : $obj->getUpdatedBy()->getId(),
            ];
        } elseif ($this->className === User::class) {
            $objBd->users[] = [
                "id" => count($objBd->users) + 1,
                "name" => $obj->getName(),
                "createdAt" => $obj->getCreatedAt()->format('Y-m-d H:i:s'),
                "createdBy" => $obj->getCreatedBy() === null ? null : $obj->getCreatedBy()->getId(),
                "updatedAt" => $obj->getUpdatedAt() === null ? null : $obj->getUpdatedAt()->format('Y-m-d H:i:s'),
                "updatedBy" => $obj->getUpdatedBy() === null ? null : $obj->getUpdatedBy()->getId(),
            ];
        } elseif ($this->className === Place::class) {
            $objBd->places[] = [
                "id" => count($objBd->places) + 1,
                "name" => $obj->getName(),
                "createdAt" => $obj->getCreatedAt()->format('Y-m-d H:i:s'),
                "createdBy" => $obj->getCreatedBy() === null ? null : $obj->getCreatedBy()->getId(),
                "updatedAt" => $obj->getUpdatedAt() === null ? null : $obj->getUpdatedAt()->format('Y-m-d H:i:s'),
                "updatedBy" => $obj->getUpdatedBy() === null ? null : $obj->getUpdatedBy()->getId(),
            ];
        }
        file_put_contents(__DIR__ . "/db.json", json_encode($objBd, JSON_THROW_ON_ERROR));

        return true;
    }

    private function addCommonTrait(object $objEntity, object $objFromDb): void
    {
        $objRepoUser = new Repository(User::class);
        if ($objFromDb->createdAt !== null) {
            $objEntity->setCreatedAt(DateTime::createFromFormat("Y-m-d H:i:s", $objFromDb->createdAt));
        }
        if ($objFromDb->createdBy !== null) {
            $objEntity->setCreatedBy($objRepoUser->find($objFromDb->createdBy));
        }
        if ($objFromDb->updatedAt !== null) {
            $objEntity->setUpdatedAt(DateTime::createFromFormat("Y-m-d H:i:s", $objFromDb->updatedAt));
        }
        if ($objFromDb->updatedBy !== null) {
            $objEntity->setUpdatedBy($objRepoUser->find($objFromDb->updatedBy));
        }
    }
}