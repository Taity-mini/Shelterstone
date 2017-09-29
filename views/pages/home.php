<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:48
 * Home page
 */
?>

<h1 class="pageTitle">Welcome to Shelterstone!</h1>
<br/>

    <div class="small-7 small-centered columns">
    <div class="orbit" aria-label="Shelterstone trips" data-orbit>
        <ul class="orbit-container" style="height: 341px; width: 500px;">
            <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous Slide</span>&#9664;
            </button>
            <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>
            <?php

            if ($photoList != null) {

                $count = 0;
                $max = sizeof($photoList);

                foreach ($photoList as $photos) {
                    $photo = new gallery_photos();
                    $photo->setPhotoID($photos["photoID"]);
                    $photo->getAllDetails($conn);
                    $count += $count;
                    if ($count = 0) {
                        echo '
                       <li class="is-active orbit-slide">
                       <img width="500px" height="341px" src="' . $photo->getFullFilePath() . '"/>
                       </li>
                ';
                    } else {
                        echo '<li class="orbit-slide">
                        <div>
                        <img width="500px" height="341px" src="' . $photo->getFullFilePath() . '"/>
                        </div>
                    </li>';
                    }

                }
                echo "</ul>";
                echo '<nav class="orbit-bullets">';
                for ($i = 0; $i < $max; $i++) {
                    if ($i == 0) {
                        echo '<button class="is-active" data-slide="0"><span class="show-for-sr">' . $i . ' slide details.</span><span class="show-for-sr">Current Slide</span></button>';
                    } else {
                        echo '<button data-slide="' . $i . '"><span class="show-for-sr">' . $i . ' slide details.</span></button>';
                    }

                }
                echo ' </nav>';
            } else {
                echo '
                 <li class="is-active orbit-slide">

                <img src="img/slider/slider_1.png"/>
            </li>
            <li class="orbit-slide">
                <div>
                    <img src="img/slider/slider_2.png"/>
                </div>
            </li>
            <li class="orbit-slide">
                <div>
                    <img src="img/slider/slider_3.png"/>
                </div>
            </li>
            <li class="orbit-slide">
                <div>
                    <img src="img/slider/slider_4.png"/>
                </div>
            </li>
        </ul>
        <nav class="orbit-bullets">
            <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span
                        class="show-for-sr">Current Slide</span></button>
            <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
            <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
            <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
        </nav>
                
                ';
            }
            ?>

    </div>
</div>
<h3 class="text-center">RGU's very own Climbing and Mountaineering Club!</h3>

<br/>

<h2 class="text-center">Recent News</h2>
<?php
if ($newsList == null) {
    echo "Sorry there hasn't been any news added currently. Please come back later.";
}

foreach ($newsList as $news) {
    $newsArticle->setNewsID($news["newsID"]);
    $newsArticle->getAllDetails($conn);
    $author->setUserID($newsArticle->getUserID());
    $author->getAllDetails($conn);
    $newsLink = $_SESSION['domain'] . "news/" . $newsArticle->getNewsID();
    $typeLink = $_SESSION['domain'] . "news/type/" . $newsArticle->getType();

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

?>

