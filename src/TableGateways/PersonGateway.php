<?php
namespace Src\TableGateways;

class PersonGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT
               *
            FROM
                users;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT
                *
            FROM
                users
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
        INSERT INTO users(
                id, userName, userPassword, dateCreation, firstName, lastName, emailx)
            VALUES
                (:id, :userName, :userPassword, :dateCreation, :firstName, :lastName, :email);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => $input['id'],
                'userName' => $input['userName'],
                'userPassword'  => $input['userPassword'],
                'dateCreation' => $input['dateCreation'],
                'firstName' => $input['firstName'] ?? null,
                'lastName' => $input['lastName']  ?? null,
                'email'  => $input['email']  ?? null
            ));

            return $statement->rowCount();
        } catch (\PDOException $e) {
            echo($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE users
            SET
                userName = :userName,
                userPassword  = :userPassword,
                dateCreation = :dateCreation,
                firstName = :firstName,
                lastName = :lastName,
                email = :email
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM users
            WHERE userName = :userName;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}