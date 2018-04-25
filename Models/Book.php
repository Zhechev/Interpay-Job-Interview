<?php
/**
 * Created by PhpStorm.
 * User: Mitacheto
 * Date: 24.4.2018 г.
 * Time: 23:25 ч.
 */

namespace Models;

class Book
{
    private $host = 'localhost';
    private $port = 5432;
    private $dbName = 'postgres';
    private $user = 'postgres';
    private $password = '123456';

    private $db_conn;

    public function __construct()
    {
        $this->db_conn = pg_connect("host=$this->host port=$this->port dbname=$this->dbName user=$this->user password=$this->password");
    }

    /**
     * @return resource
     */
    public function getDbConn()
    {
        return $this->db_conn;
    }

    public function searchAuthor($words)
    {
        $sql = "SELECT author FROM books WHERE author ILIKE '%$words%'";
        $query = pg_query($this->getDbConn(), $sql);
        $results = pg_fetch_all($query);

        return $results;
    }

    public function checkAuthorExists($authorName) {
        $sqlCheckAuthor = "SELECT author FROM books WHERE author ILIKE '%$authorName%'"; // Get if author already exists
        $query = pg_query($this->getDbConn(), $sqlCheckAuthor);

        if (pg_num_rows($query) > 0) {
            return true;
        }

        return false;
    }

    public function getRow($authorName) {
        $sqlGetRow = "SELECT * FROM books WHERE author = '" . $authorName . "'"; // return row with author
        $query = pg_query($this->getDbConn(), $sqlGetRow);

        return pg_fetch_assoc($query);
    }

    public function updateBook($id) {
        $sqlUpdateDate = "Update books SET date_added = '" . date("Y-m-d H:i:s") . "' WHERE id = '" . (int)$id . "'";
        $query = pg_query($this->getDbConn(), $sqlUpdateDate);
    }

    public function addBook($book) {
        //$sqlAddBook = pg_prepare($this->getDbConn(), "addBook", 'INSERT INTO books VALUES (default, $1, $2, $3)');
        //$addBook = pg_execute($this->getDbConn(), "addBook", array($book['author'], $book['name'], date("Y-m-d H:i:s")));
        $author = $book['author'];
        $name = $book['name'];
        $time = date('Y-m-d H:i:s');

        $sqlAddBook = "INSERT INTO books(id, author, name, date_added)VALUES (default, '$author', '$name', '$time')";
        $query = pg_query($this->getDbConn(), $sqlAddBook);
    }

    public function getAllBooks() {
        $results = pg_query($this->getDbConn(), 'SELECT * FROM books');

        if (pg_num_rows($results) > 0) {
            $results = pg_fetch_all($results);
        }

        return $results;
    }
}