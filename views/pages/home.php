<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:48
 * Home page
 */
?>

<h1 class="pageTitle" >Welcome to Shelterstone!</h1>
<br/>
<div class="orbit"aria-label="Shelterstone trips" data-orbit>
    <ul class="orbit-container" style="height: 341px; width: 500px;">
        <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous Slide</span>&#9664;</button>
        <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>
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
        <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
        <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
        <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
        <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
    </nav>
</div>

<h3>Description..</h3>
<p>Here..</p>
