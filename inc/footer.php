<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 18:00
 * Footer include file used in the design layout
 */
?>
<!--END Main Content-->
</div>
</div>
<!--START FOOTER-->

<footer class="footer_background">
    <div class="large-12 text-center">
        <div class="large-4 small-12  columns footer_background">

            <p> <b>Club Sponsor: </b> <a href="http://illicit-still.co.uk/"><img class="sponsor-logo" src="<?php echo $domain ?>img/illicit-still-logo.svg"/></a></p>

            <a href="https://www.rguunion.co.uk/organisation/shelterstone/"><img class="rgu-logos" src="<?php echo $domain ?>img/rgu_union.png"></a>

            <a href="https://www3.rgu.ac.uk/student-life/campus-life/rgu-sport/facilities/climb/climbing"><img class="rgu-logos" src="<?php echo $domain ?>img/rgu_sport.jpg"></a>
        </div>
        <div class="large-4 small-12 columns footer_background">
            <p><b>Copyright &copy; <?php echo date("Y"); ?>  Shelterstone</b>
        </div>
        <div class="large-4 small-12 columns footer_background">
            <a href="https://www.facebook.com/groups/146226435444638/" class="button social facebook">
                <i class="social-media fi-social-facebook" aria-hidden="true"></i> Facebook
            </a>
            <a href="https://www.instagram.com/rgu_climb/" class="button social instagram">
                <i class="social-media fi-social-instagram" aria-hidden="true"></i> Instagram
            </a>
            <p><i>Website Developed with <i class="fi-heart"> by <a href="https://github.com/Taity-mini/Shelterstone">Andrew Tait</a></i></p>

        </div>
    </div>
</footer>
</div>
<!--END FOOTER-->

<script src="<?php echo $domain ?>/js/vendor/foundation.js"></script>
<script src="<?php echo $domain ?>js/vendor/what-input.min.js"></script>

<script>
    $(document).foundation();
</script>
</body>
</html>