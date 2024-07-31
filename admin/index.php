<?php

declare(strict_types=1);
require '../includes/database-connection.php';
require '../includes/functions.php';

$sql = "SELECT count(id) FROM article";
$article_count = pdo($pdo, $sql)->fetchColumn();
$sql = "SELECT count(id) FROM category";
$category_count = pdo($pdo, $sql)->fetchColumn();
?>

<?php include '../includes/admin-header.php'; ?>
<main class="container" id="content">
    <section>
        <h1>Admin</h1>
    </section>
    <table class="admin">
        <tr>
            <th></th>
            <th>Count</th>
            <th class="create">Create</th>
            <th class="view">View</th>
        </tr>
        <tr>
            <td><strong>Categories</strong></td>
            <td><?= $category_count ?></td>
            <td><a href="category.php" class="btn btn-primary">Add</a></td>
            <td><a href="categories.php" class="btn btn-primary">View</a>
            </td>
        </tr>
        <tr>
            <td><strong>Articles</strong></td>
            <td><?= $article_count ?></td>
            <td><a href="article.php" class="btn btn-primary">Add</a></td>
            <td><a href="articles.php" class="btn btn-primary">View</a>
            </td>
        </tr>
    </table>
</main>
<?php include '../includes/admin-footer.php'; ?>