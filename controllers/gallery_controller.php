<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 16:02
 * Gallery Controller
 */

class gallery_controller
{

    function constructor()
    {
        require_once('./models/gallery_photos.php');
        require_once('./models/gallery_albums.php');
        require_once('./models/users.php');
    }

    public function home()
    {
        require_once ('./views/gallery/index.php');
    }

    //Viewing functions

    public function viewAlbum()
    {
        require_once ('./views/gallery/view_album.php');
    }

    public function viewPhoto()
    {
        require_once ('./views/gallery/view_photo.php');
    }

    //Adding functions

    public function addAlbum()
    {
        require_once ('./views/gallery/create_album.php');
    }

    public function addPhoto()
    {
        require_once ('./views/gallery/upload.php');
    }

    //Editing functions

    public function editAlbum()
    {
        require_once ('./views/gallery/edit_album.php');
    }

    public function editPhoto()
    {
        require_once ('./views/gallery/edit_photo.php');
    }


    //Other methods
    public function personalAlbum()
    {
        require_once ('./views/gallery/personal_album.php');
    }

    public function events()
    {
        require_once ('./views/gallery/events.php');
    }

}