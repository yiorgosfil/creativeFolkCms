<?php

declare(strict_types=1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    redirect('articles.php', ['failure' => 'Article not found']);
}

$article = false;
$sql = "SELECT a.title, a.image_id,
        i.file AS image_file
        FROM article AS a
        LEFT JOIN image AS i ON a.image_id = i.id
        WHERE a.id = :id;";
$article = pdo($pdo, $sql, [$id])->fetch();
if (!$article) {
    redirect('articles.php', ['failure' => 'Article not found']);
}

// 1. If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // The beginTransaction() method is specifically used to initiate a
        // transaction. It is part of the PDO class and can be called on an instance of PDO
        // that represents an active database connection. This method starts a transaction,
        // which means that all subsequent database operations will be part of this
        // transaction until the transaction is either committed or rolled back.
        $pdo->beginTransaction();

        // 2. If there is an image, delete the image first
        if ($article['image_id']) {
            $sql = "UPDATE article SET image_id = null WHERE id = :article_id;"; // Dissociate the image from the article in the database
            pdo($pdo, $sql, [$id]); // Remove image from article
            $sql = "DELETE FROM image WHERE id = :id"; // // SQL to delete from image table
            pdo($pdo, $sql, [$article['image_id']]); // Delete from image table
            $path = '../uploads/' . $article['image_file']; // Set the image path
            if (file_exists($path)) {
                $unlink = unlink($path);
            }
        }

        // 3. Then delete the article
        $sql = "DELETE FROM artcle WHERE id = :id;";
        pdo($pdo, $sql, [$id]);
        $pdo->commit();
        redirect('articles.php', ['success' => 'Article deleted']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
<main class="container admin" id="content">
    <form action="article-delete.php?id=<?= $id ?>" method="post" class="narrow">
        <h1>Delete article</h1>
        <p>Click confirm to delete the article: <em><?= html_escape($article['title']) ?></em></p>
        <input type="submit" name="delete" value="Confirm" class="btn btn-primary">
        <a href="articles.php" class="btn btn-danger">Cancel</a>
    </form>
</main>
<?php include '../includes/admin-footer.php'; ?>