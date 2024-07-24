<?php

declare(strict_types=1);
require 'includes/database-connection.php'; // This creates the PDO object
require 'includes/functions.php';

// SQL to get latest articles
$sql = "SELECT a.id, a.title, a.summary, a.category_id, a.member_id,
        c.name AS category,
        CONCAT(m.forename, ' ', m.surname) AS author,
        i.file AS image_file,
        i.alt AS image_alt
        FROM article as a
        JOIN category AS c ON a.category_id = c.id
        JOIN member AS m ON a.member_id = m.id
        LEFT JOIN image AS i ON a.image_id = i.id
        WHERE a.published = 1
        ORDER BY a.id DESC
        LIMIT 6;";

// Get summaries
$articles = pdo($pdo, $sql)->fetchAll();

// SQL to get categories
$sql = "SELECT id, name
        FROM category
        WHERE navigation = 1;";

// Get navigation categories
$navigation = pdo($pdo, $sql)->fetchAll();

$section = ''; // Current category
$title = 'Creative Folk'; // HTML <title> content
$description = 'A collective of creatives for hire'; // Meta description content 
?>

<?php include 'includes/header.php'; ?>
<main class="container grid" id="content">
    <?php foreach ($articles as $article) { ?>
        <article class="summary">
            <a href="article.php?id=<?= $article['id'] ?>">
                <img src="uploads/<?= html_escape($article['image_file'] ?? 'blank.phg') ?>"
                    alt="<?= html_escape($article['image_alt']) ?>">
                <h2><?= html_escape($article['title']) ?></h2>
                <p><?= html_escape($article['summary']) ?></p>
            </a>
            <p class="credit">
                Posted in <a href="category.php?id=<?= $article['category_id'] ?>">
                    <?= html_escape($article['category']) ?></a>
                By <a href="member.php?id=<?= $article['member_id'] ?>">
                    <?= html_escape($article['author']) ?></a>
            </p>
        </article>
    <?php } ?>
</main>
<?php include 'includes/footer.php'; ?>