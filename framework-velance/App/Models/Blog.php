<?php
namespace App\Models;

class Blog
{
    private static $table = 'posts';

    private static function getConnection() {
        return new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    }

    public static function select(int $id) {
        $connPdo = self::getConnection();

        $sql = 'SELECT * FROM '.self::$table.' WHERE id = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum post encontrado!");
        }
    }

    public static function selectAll() {
        $connPdo = self::getConnection();

        $sql = 'SELECT * FROM '.self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum post encontrado!");
        }
    }

    public static function insert($data) {
        $connPdo = self::getConnection();

        $sql = 'INSERT INTO '.self::$table.' (title, content, author) VALUES (:ti, :co, :au)';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':ti', $data['title']);
        $stmt->bindValue(':co', $data['content']);
        $stmt->bindValue(':au', $data['author']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Post inserido com sucesso!';
        } else {
            throw new \Exception("Falha ao inserir post!");
        }
    }

    public static function delete(int $id) {
        $connPdo = self::getConnection();

        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Post deletado com sucesso!';
        } else {
            throw new \Exception("Falha ao deletar post ou post não encontrado!");
        }
    }
}
