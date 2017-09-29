<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 16:51
 * News Article Page
 */

if (isset($_SESSION['update'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>News Article Successfully Updated!</h5>
          </div>';
    unset($_SESSION['update']);
}

$typeLink = $_SESSION['domain'] . "news/type/" . $newsArticle->getType();
$userLink = $_SESSION['domain'] . "news/user/" . $newsArticle->getUserID();

?>
<div class="blog-post">
    <h1 class="pageTitle"><?= $newsArticle->getTitle(); ?>
        <small><?= $newsArticle->getDate(); ?></small>
        <?php
        if ($edit) {
            echo ' <a href="/news/edit/' . $newsArticle->getNewsID() . '" class="button">[Edit]</a>';
        }
        ?>
    </h1>
    <p><?= $newsArticle->getMainBody(); ?></p>
    <div class="callout">
        <ul class="menu simple">
            <li><a href="<?= $userLink ?>">Author: <?= $author->getFullName(); ?></a></li>
            <li><a href="<?= $typeLink ?>">Type: <?= $newsArticle->displayType(); ?></a></li>
            <?php
            if ($edit) {
            echo '<li>Visibility:'.$newsArticle->displayVisibility().'</li>';
            }
            ?>

        </ul>
    </div>
</div>

<a href="/news/" class="button">Return to Main News</a>
