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
<!--START FOOTER-->
<footer class="row">
        <hr/>
        <div class="row">
            <div class="large-6 columns">

                <p>&copy; <?php echo date("Y"); ?> Copyright Shelterstone</p>
            </div>
            <div class="large-6 columns">

                <ul class="inline-list right">
                    <li><a href="#">Links go here</a></li>
                </ul>
            </div>
        </div>
</footer>
<!--END FOOTER-->
<script src="<?php echo $domain ?>/js/vendor/jquery.js"></script>
<script src="<?php echo $domain ?>/js/vendor/foundation.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>
