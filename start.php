<?php
/**
 * Created by PhpStorm.
 * User: Mitko Zhechev
 * Date: 24.4.2018 г.
 * Time: 19:59 ч.
 */

include_once "Controllers\Xml.php";
include_once "Models\Book.php";

$bookModel = new Models\Book();

if (isset($_GET['searchText'])) {
    $words = urldecode($_GET['searchText']);
    $results = $bookModel->searchAuthor($words);
    echo json_encode($results);
    exit;
}

$directory = 'xmls';

if (!is_dir($directory)) {
    $di = new RecursiveDirectoryIterator('xmls');
}

if (isset($di)) {
    foreach (new RecursiveIteratorIterator($di) as $filename) {
        if ($filename->isDir()) {
            continue;
        }
        $xmlsPath[] = str_replace("\\", "/", $filename->getPathname());
    }
}

$xml = new Controllers\Xml();

if (isset($xmlsPath)) {
    $filesContent = $xml->getFilesContentFromXml($xmlsPath);
}

if (isset($filesContent)) {
    $books = $xml->getBooksFromContent($filesContent);
}

if (isset($books)) {
    $books = call_user_func_array('array_merge', $books);

    foreach ($books as $book) {
        $authorName = $book['author'];
        $authorExists = $bookModel->checkAuthorExists($authorName);

        if ($authorExists) {
            $row = $bookModel->getRow($authorName);

            if (trim($row['name']) == trim($book['name'])) { // if current book name == db row name (author already exists)
                $bookModel->updateBook($row['id']);
            }
        } else {
            $bookModel->addBook($book);
        }
    }
}

$allBooks = $bookModel->getAllBooks();

echo json_encode($allBooks);