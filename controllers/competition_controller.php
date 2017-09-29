<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 19/03/2017
 * Time: 23:28
 * Competitions pages controller
 */

class competition_controller  extends controller
{
    function constructor()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/competition.php');
        require_once('./models/competition_results.php');
    }

    public function competitions()
    {
        require_once ('./views/competitions/comps.php');
    }

    public function competition_results()
    {
        require_once ('./views/competitions/comp_results.php');
    }

    public function competition_results_edit()
    {
        require_once ('./views/competitions/comp_results_edit.php');
    }

    public function competition_add()
    {
        require_once ('./views/competitions/comps_add.php');
    }

    public function competition_edit()
    {
        require_once ('./views/competitions/comps_edit.php');
    }


}