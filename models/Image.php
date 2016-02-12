<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 11.02.2016
 * Time: 14:55
 */

namespace models;


use app\App;
use app\BaseModel;
use app\Validator;
use finfo;
use PDO;

class Image extends BaseModel
{
    public $id;
    public $uid;
    public $path;
    public $date;
    protected $description;

    protected static $dbProperties =[
        'id',
        'uid',
        'path',
        'date',
        'description'
    ];

    public $imageFile;

    /**
    * List of properties available for mass assignment
    * @var array
    */
    protected $safeProperties = [
        'description'
    ];

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @param string|null $scenario
     */
    public function __constructor ( $scenario = null )
    {
        parent::__construct( $scenario );
    }

    /**
     * Model validator
     * @return bool
     */
    public function validate( $clearErrors = true )
    {
        if ( $clearErrors ) {
            $this->propertyErrors = [];
        }

        Validator::required($this, 'uid', ['create']);
        Validator::required($this, 'path', ['create']);
        Validator::required($this, 'date', ['create']);
        Validator::required($this, 'description', ['create']);

        Validator::strMaxLength($this, 'path', 512, ['create']);
        Validator::strMaxLength($this, 'description', 255, ['create']);

        return empty($this->propertyErrors);
    }

    /**
     * @return bool
     */
    public function uploadFile()
    {
        if ( !isset($this->imageFile) ) {
            $this->addErrorMsg('imageFile', 'Please select an image file.');

            return false;
        }

        if ( is_uploaded_file($_FILES[$this->imageFile]['tmp_name']['imageFile'])) {
            if ( UPLOAD_ERR_OK == $_FILES[$this->imageFile]['error']['imageFile'] ) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                        $finfo->file($_FILES[$this->imageFile]['tmp_name']['imageFile']),
                        array(
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                        ),
                        true
                    )) {
                    $this->addErrorMsg('imageFile', 'Wrong file type - only JPG, PNG,GIF allowed.');

                    return false;
                }

                $tmpName = $_FILES[$this->imageFile]['tmp_name']['imageFile'];
                $destPath = $this->getUserImgDirectory() . $_FILES[$this->imageFile]['name']['imageFile'];
                $this->path = $this->getUserImgDirectoryRel() . $_FILES[$this->imageFile]['name']['imageFile'];

                if (file_exists($destPath)) {
                    //generates unique file name
                    $salt = substr(md5(microtime()), 0, 5);

                    $destPath = $this->getUserImgDirectory() . $salt . $_FILES[$this->imageFile]['name']['imageFile'];
                    $this->path = $this->getUserImgDirectoryRel() . $salt . $_FILES[$this->imageFile]['name']['imageFile'];
                }


                move_uploaded_file($tmpName, $destPath);
            } else {
                $this->addErrorMsg('imageFile', 'Image uploading error.');

                return false;
            }
        }

        return true;
    }

    /**
     * Saves model
     * @param bool $validate
     * @return bool
     */
    public function save($validate = true)
    {
        $this->uid = App::instance()->getUser()->getId();
        $this->date = time();

        if ($validate && !$this->validate( $this->uploadFile() )) {

            return false;
        }

        $tableName = static::tableName();

        $sql = "INSERT INTO {$tableName} (uid, path, date, description)
                VALUES (:uid, :path, :date, :description)";

        $values = [
            ':uid' => $this->uid,
            ':path' => $this->path,
            ':date' => $this->date,
            ':description' => $this->description
        ];

        $connection = App::instance()->getDB();
        $smnt = $connection->prepare($sql);

        if ( $smnt->execute($values) ) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $tableName = static::tableName();

        $sql = "DELETE FROM {$tableName} WHERE id = :id LIMIT 1";

        $values = [
            ':id' => $this->id,
        ];

        $connection = App::instance()->getDB();
        $smnt = $connection->prepare($sql);

        if ( $smnt->execute($values) ) {

            $filePath = str_replace('/', DIRECTORY_SEPARATOR, App::instance()->getWebRootPath() . '/' . $this->path);
            unlink( $filePath );

            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getUserImgDirectoryRel()
    {
        return 'images/' . sha1($this->uid) . '/';
    }

    /**
     * @return string
     */
    public function getUserImgDirectory()
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, App::instance()->getWebRootPath() . '/' . $this->getUserImgDirectoryRel());

        if ( !file_exists( $path )) {
            mkdir( $path, 0777, true );
        }

        return $path;
    }

    /**
     * @return string
     */
    public function getDescription( )
    {
        return $this->description;
    }

    /**
     * @param string $value
     * @return string
     */
    public function setDescription( $value )
    {
        return htmlspecialchars( $value );
    }
} 