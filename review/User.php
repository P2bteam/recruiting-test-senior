<?php

namespace review;
use BD;

class User
{
    /**
     * Rôle utilisateur de base
     */
    public const LEVEL_USER = 1;
    /**
     * @var int ID utilisateur
     */
    private int $id = 0;
    /**
     * @var string Login de l'utilisateur
     */
    private string $userName = '';
    /**
     * @var string Mot de passe de l'utilisateur
     */
    private string $password = '';
    /**
     * @var string Email de l'utilisateur
     */
    private string $email = '';

    /**
     * @var string Adresse IP d'inscription
     */
    private string $ipInscription = '';

    /**
     * @var int Rôle de l'utilisateur
     */
    private int $role = self::LEVEL_USER;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     * @throw Exception
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return void
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getIpInscription(): string
    {
        return $this->ipInscription;
    }

    /**
     * @param string $ipInscription
     * @return void
     */
    public function setIpInscription(string $ipInscription): void
    {
        $this->validIpInscription($ipInscription);
        $this->ipInscription = $ipInscription;
    }

    /**
     * @param string $ipInscription
     * @return void
     */
    public function validIpInscription(string $ipInscription): void
    {
        if (!preg_match("#[0-9]{3}.[0-9]{3}.[0-9]{3}.[0-9]{3}#", $ipInscription)) {
            throw new Exception("Invalid IP inscription");
        }
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return void
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    /**
     * Connexion d'un utilisateur
     *
     * @param string $username Login
     * @param string $password Mot de passe
     * @return ?int
     */
    public function signIn(string $username, string $password): ?int
    {
        $querySql = "SELECT PASSWORD, ID
            FROM " . $GLOBALS["table_users"] . "
            WHERE USERNAME = '" . $username . "'";
        $result = BD::execute($querySql);
        if (BD::rowCount($result) > 0) {
            while ($row = BD::fetch($result)) {
                if ($row["PASSWORD"] === $password) {
                    return $row["ID"];
                }
            }
        }

        return null;
    }

    /**
     * Charger l'utilisateur
     *
     * @param string $nom
     * @return void
     */
    public function load(int $utilisateur): void
    {
        $querySql = "SELECT *
            FROM " . $GLOBALS["table_users"] . "
            WHERE ID = '" . $utilisateur . "'";
        $result = BD::execute($querySql);
        if (BD::rowCount($result) > 0) {
            while ($row = BD::fetch($result)) {
                $this->setId($row["ID"]);
                $this->setUserName($row["USERNAME"]);
                $this->setPassword($row["PASSWORD"]);
                $this->setEmail($row["EMAIL"]);
                $this->setIpInscription($row["IP_INSCRIPTION"]);
                $this->setRole($row["ROLE"]);
            }
        }
    }

    /**
     * Inscription d'un utilisateur
     *
     * @param array $request Données du formulaire
     *
     * @return bool
     */
    public function register(array $request): bool
    {
        $querySql = "INSERT INTO " . $GLOBALS["table_users"] . "
            (
                USERNAME,
                PASSWORD,
                EMAIL,
                IP_INSCRIPTION
            ) VALUES (
            '" . $request["userName"] . "',
            '" . $request["userPassword"] . "',
            '" . $request["userMail"] . "',
            '" . $request["REMOTE_ADDR"] . "'
            )";
        return BD::execute($querySql);
    }
}
