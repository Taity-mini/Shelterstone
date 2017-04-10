<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 10/03/2017
 * Time: 16:51
 * Shelterstone news list page
 */
if (isset($_SESSION['create'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>News article Successfully Added!</h5>
          </div>';
    unset($_SESSION['create']);
}

if (isset($_SESSION['delete'])) {
    echo '<br/>';
    echo '<div class="callout alert">
          <h5>News article Successfully Deleted!</h5>
          </div>';
    unset($_SESSION['delete']);
}


echo '<h1 class="pageTitle">' . $heading . '</h1>';
echo '<p>' . $description . '</p>';

if ($newsList == null) {
    echo "Sorry there hasn't been any news added currently. Please come back later.";
}

foreach ($newsList as $news) {
    $newsArticle->setNewsID($news["newsID"]);
    $newsArticle->getAllDetails($conn);
    $author->setUserID($newsArticle->getUserID());
    $author->getAllDetails($conn);
    $newsLink = $_SESSION['domain'] . "/news/" . $newsArticle->getNewsID();
    $typeLink = $_SESSION['domain'] . "/news/type/" . $newsArticle->getType();

    echo '
    <div class="row medium-8 large-12 columns">
     <div class="blog-post">
        <h3><a href="' . $newsLink . '">' . $newsArticle->getTitle() . '</a>
            <small>' . $newsArticle->getDate() . '</small>
        </h3>
        <p>' . $newsArticle->getMainBody() . '</p>
        <div class="callout">
            <ul class="menu simple">
                <li>Author: ' . $author->getFullName() . '</li>
                <li><a href="' . $typeLink . '">Type: ' . $newsArticle->displayType() . '</a></li>
            </ul>
        </div>
     </div>
    </div>
    ';
}

//If user has editing privileges then display create news button
if ($create) {
    echo '<a href="/news/add" class="button">Create news article</a>';
}
