<?php
namespace App\Models;

class VideoAulas
{
    private static $table = 'video_aulas';

    private static function getConnection() {
        return new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    }

    public static function select(int $id) {
        $connPdo = self::getConnection();

        $sql = '
            SELECT 
                v.id,
                v.titulo,
                v.descricao,
                v.url_video,
                v.created_at,
                v.updated_at,
                u.id as autor_id,
                u.nome as autor_nome,
                u.email as autor_email
            FROM '.self::$table.' v
            INNER JOIN login u ON v.autor_id = u.id
            WHERE v.id = :id
        ';

        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhuma vídeo aula encontrada!");
        }
    }

    public static function selectAll() {
        $connPdo = self::getConnection();

        $sql = '
            SELECT 
                v.id,
                v.titulo,
                v.descricao,
                v.url_video,
                v.created_at,
                v.updated_at,
                u.id as autor_id,
                u.nome as autor_nome,
                u.email as autor_email
            FROM '.self::$table.' v
            INNER JOIN login u ON v.autor_id = u.id
        ';

        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhuma vídeo aula encontrada!");
        }
    }

    public static function insert($data) {
        $connPdo = self::getConnection();

        $sql = 'INSERT INTO '.self::$table.' (titulo, descricao, url_video, autor_id) VALUES (:ti, :de, :ur, :au)';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':ti', $data['titulo']);
        $stmt->bindValue(':de', $data['descricao']);
        $stmt->bindValue(':ur', $data['url_video']);
        $stmt->bindValue(':au', $data['autor_id']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Vídeo aula inserida com sucesso!';
        } else {
            throw new \Exception("Falha ao inserir vídeo aula!");
        }
    }

    public static function delete(int $id) {
        $connPdo = self::getConnection();

        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Vídeo aula deletada com sucesso!';
        } else {
            throw new \Exception("Falha ao deletar vídeo aula ou vídeo aula não encontrada!");
        }
    }
}
