<?php

declare(strict_types=1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$category = '';

if (!$id) {
    redirect('categories.php', ['failure' => 'Category not found']);
}

$sql = "SELECT name from category WHERE id = :id;";
$category = pdo($pdo, $sql, [$id])->fetchColumn();
if (!$category) {
    redirect('categories.php', ['failure' => 'Category not found']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $sql = "DELETE FROM category WHERE id = :id;";
        pdo($pdo, $sql, [$id]);
        redirect('categories.php', ['success' => 'Category deleted']);
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1451) {
            redirect('categories.php', ['failure' => 'Category contains articles that must be
                moved or deleted before they can be deleted.']);
        } else {
            throw $e;
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
<main class="container admin" id="content">
    <form action="category-delete.php?id=<?= $id ?>" method="post" class="narrow">
        <h1>Delete category</h1>
        <p>Click confirm to delete the category: <em><?= html_escape($category) ?></em></p>
        <input type="submit" name="delete" value="Confirm" class="btn btn-primary">
        <a href="categories.php" class="btn btn-danger">Cancel</a>
    </form>
</main>
<?php include '../includes/admin-footer.php'; ?>