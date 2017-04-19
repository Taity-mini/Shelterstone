<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 16:02
 * Gallery Controller
 */
class gallery_controller extends controller
{

    public function home()
    {
        require_once('./models/gallery_photos.php');
        require_once('./models/gallery_albums.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $user = new users();
        $album = new gallery_album();
        $adding = false;
        $photo = new gallery_photos();

        $heading = "";
        $description = "";

        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if (!$groups->galleryFullAccess($conn, $_SESSION['userID'])) {
                $albumsList = $album->listAllAlbums($conn);
                $heading = "Index";
                $description = "All albums by Shelterstone members";
            } else {
                $adding = true;
                $heading = "Index";
                $description = "All albums by Shelterstone members";
                $albumsList = $album->listAllAlbums($conn);
            }
        } else {
            $heading = "Index";
            $description = "All public Shelterstone gallery albums";
            $albumsList = $album->listAllPublicAlbums($conn);
        }

        //Display user data in forms
        $this->data['albums'] = $album;
        $this->data['albumList'] = $albumsList;
        $this->data['author'] = $user;
        $this->data['photos'] = $photo;
        $this->data['create'] = $adding;
        $this->date['heading'] = $heading;
        $this->date['description'] = $description;

        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/gallery/index.php');
    }

    //Viewing functions

    public function viewAlbum()
    {
        require_once('./models/gallery_photos.php');
        require_once('./models/gallery_albums.php');
        require_once('./models/users.php');

        $conn = dbConnect();

        $albums = new gallery_album();
        $albums->setAlbumID($_SESSION['params']['albumID']);
        $albums->getAllDetails($conn);

        if (!$albums->doesExist($conn)) {
            $this->redirect("/error");
        }

        if (!isset($_SESSION['userID']) && $albums->getVisibility() == 0) {
            $this->redirect("/login");
        }

        $users = new Users($albums->getUserID());
        $users->getAllDetails($conn);

        $photos = new gallery_photos();
        $photos->setAlbumID($albums->getAlbumID());
        $photo_listing = $photos->listPhotoAlbum($conn);

        $canEdit = false;

        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if ($groups->newsFullAccess($conn, $_SESSION['userID'])) {
                $canEdit = true;
            } else if ($users->getUserID() == $_SESSION['userID']) {
                $canEdit = true;
            }
        }


        //Display user data in forms

        $this->data['albums'] = $albums;
        $this->data['photos'] = $photos;
        $this->data['photoList'] = $photo_listing;
        $this->data['author'] = $users;
        $this->data['edit'] = $canEdit;


        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/gallery/view_album.php');
    }

    public function viewPhoto()
    {
        require_once('./models/gallery_photos.php');
        require_once('./models/gallery_albums.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $photos = new gallery_photos();
        $photos->setPhotoID($_SESSION['params']['photoID']);
        $photos->getAllDetails($conn);


        if (!$photos->doesExist($conn)) {
            $this->redirect("/error");
        }


        $users = new Users($photos->getUserID());
        $albums = new gallery_album($photos->getAlbumID());
        $albums->getAllDetails($conn);
        $users->getAllDetails($conn);

        $canEdit = false;

        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if ($groups->newsFullAccess($conn, $_SESSION['userID'])) {
                $canEdit = true;
            } else if ($users->getUserID() == $_SESSION['userID']) {
                $canEdit = true;
            }
        }


        $this->data['albums'] = $albums;
        $this->data['photos'] = $photos;
        $this->data['author'] = $users;
        $this->data['edit'] = $canEdit;

        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/gallery/view_photo.php');
    }

    //Adding functions

    public function addAlbum()
    {
        if (isset($_SESSION['userID'])) {
            require_once('./models/gallery_photos.php');
            require_once('./models/gallery_albums.php');
            require_once('./models/users.php');
            $conn = dbConnect();

            //If create new button is submitted
            if (isset($_POST['btnSubmit'])) {

                $user = new users($_SESSION['userID']);
                $user->getAllDetails($conn);
                $albums = new gallery_album();

                if (isset($_POST['txtName']) && (isset($_POST['txtDescription']))) {
                    $albums->setAlbumName(htmlentities($_POST['txtName']));
                    $albums->setAlbumDescription(htmlentities($_POST['txtDescription']));
                    $albums->setVisibility(htmlentities($_POST['chkVisibility']));
                    $albums->setType(htmlentities($_POST['sltType']));
                    $albums->setUserID($user->getUserID());

                    if ($albums->create($conn)) {
                        $_SESSION['create'] = true;
                        $this->redirect("/gallery");
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            require_once('./views/gallery/create_album.php');

        } else {
            $this->redirect("/login");
        }
    }

    public
    function addPhoto()
    {
        if (isset($_SESSION['userID'])) {

            require_once('./models/gallery_photos.php');
            require_once('./models/gallery_albums.php');
            require_once('./models/users.php');

            $conn = dbConnect();
            $album = new gallery_album();

            $groups = new users_groups();
            if (!$groups->galleryFullAccess($conn, $_SESSION['userID'])) {
                //Standard members can upload to their own albums only.
                $albumsList = $album->listAllAlbumSelect($conn, $_SESSION['userID']);

            } else {
                //Admins can upload to any album
                $albumsList = $album->listAllAlbumSelect($conn);
            }

            if (isset($_POST['btnSubmit'])) {

                $user = new users($_SESSION['userID']);
                $user->getAllDetails($conn);

                $photos = new gallery_photos();

                if (isset($_POST['txtTitle']) && (isset($_POST['txtDescription']))) {


                    $photos->setAlbumID(htmlentities($_POST['sltAlbum']));
                    $photos->setUserID($user->getUserID());
                    $photos->setTitle(htmlentities($_POST['txtTitle']));
                    $photos->setDescription(htmlentities($_POST['txtDescription']));


                    if ($photos->uploadPhoto()) {
                        if ($photos->create($conn)) {
                            $_SESSION['upload'] = true;
                            $this->redirect("/gallery/album/" . $photos->getAlbumID());
                        }
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            //Display user data in forms
            $this->data['albums'] = $album;
            $this->data['albumList'] = $albumsList;

            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/gallery/upload.php');

        } else {
            $this->redirect("/login");
        }
    }

//Editing functions

    public function editAlbum()
    {
        if (isset($_SESSION['userID'])) {

            require_once('./models/gallery_photos.php');
            require_once('./models/gallery_albums.php');
            require_once('./models/users.php');

            $conn = dbConnect();


            $albums = new gallery_album();
            $albums->setAlbumID($_SESSION['params']['albumID']);
            $albums->getAllDetails($conn);


            if (!$albums->doesExist($conn)) {
                $this->redirect("/error");
            }

            $users = new users($_SESSION['userID']);
            $users->getAllDetails($conn);

            $canEdit = false;
            $limitedAccess = true;

            if (isset($_SESSION['userID'])) {
                $groups = new users_groups();
                if ($groups->newsFullAccess($conn, $_SESSION['userID'])) {
                    $canEdit = true;
                    $limitedAccess = false;
                } else if ($albums->getUserID() == $_SESSION['userID']) {
                    $canEdit = true;
                }
            }

            if (!$canEdit) {
                $this->redirect("/gallery/");
            }


            if (isset($_POST['btnSubmit'])) {

                $user = new users($_SESSION['userID']);
                $user->getAllDetails($conn);
                $albums = new gallery_album($_SESSION['params']['albumID']);
                $albums->getAllDetails($conn);
                if (isset($_POST['txtName']) && (isset($_POST['txtDescription']))) {
                    $albums->setAlbumName(htmlentities($_POST['txtName']));
                    $albums->setAlbumDescription(htmlentities($_POST['txtDescription']));

                    if (isset($_POST['chkVisibility']) && !$limitedAccess) {
                        $albums->setVisibility(htmlentities($_POST['chkVisibility']));
                    }
                    $albums->setType(htmlentities($_POST['sltType']));


                    if ($albums->update($conn)) {
                        $_SESSION['update'] = true;
                        $this->redirect("/gallery/album/" . $albums->getAlbumID());
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            if (isset($_POST['btnDelete'])) {

                $albums = new gallery_album(htmlentities($_SESSION['params']['albumID']));
                $albums->getAllDetails($conn);
                $photos = new gallery_photos();
                $photos->setAlbumID($albums->getAlbumID());


                //Delete all photos from the album
                if ($photos->delete($conn, $albums->getAlbumID())) {
                    //Finally delete album
                    if ($albums->delete($conn)) {
                        $_SESSION['delete'] = true;
                        $this->redirect("/gallery/");
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            //Display user data in forms
            $this->data['albums'] = $albums;
            $this->data['author'] = $users;
            $this->data['limitedAccess'] = $limitedAccess;

            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/gallery/edit_album.php');
        } else {
            $this->redirect("/login");
        }
    }

    public
    function editPhoto()
    {
        if (isset($_SESSION['userID'])) {
            require_once('./models/gallery_photos.php');
            require_once('./models/gallery_albums.php');
            require_once('./models/users.php');

            $conn = dbConnect();

            $photos = new gallery_photos(htmlentities($_SESSION['params']['photoID']));
            $photos->getAllDetails($conn);

            $users = new users($_SESSION['userID']);

            $albums = new gallery_album($photos->getAlbumID());
            $albums->getAllDetails($conn);


            if (!$photos->doesExist($conn)) {
                $this->redirect("/error");
            }

            if (isset($_POST['btnSubmit'])) {

                if (isset($_POST['txtTitle']) && (isset($_POST['txtDescription']))) {

                    $photos->setTitle(htmlentities($_POST['txtTitle']));
                    $photos->setDescription(htmlentities($_POST['txtDescription']));

                    if ($photos->update($conn)) {
                        $_SESSION['update'] = true;
                        $this->redirect("/gallery/photo/" . $photos->getPhotoID());
                        die();
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            if (isset($_POST['btnDelete'])) {

                $albumID = $photos->getAlbumID();

                //Finally delete photo
                if ($photos->delete($conn)) {
                    $_SESSION['deletePhoto'] = true;
                    $this->redirect("/gallery/album/" . $albumID);
                }
            } else {
                $_SESSION['error'] = true;
            }

            //Display user data in forms
            $this->data['albums'] = $albums;
            $this->data['author'] = $users;
            $this->data['photos'] = $photos;

            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/gallery/edit_photo.php');
        } else {
            $this->redirect("/login");
        }

    }


//Other methods
    public
    function personalAlbum()
    {
        require_once('./views/gallery/personal_album.php');
    }

    public function events()
    {
        require_once('./views/gallery/events.php');
    }

}