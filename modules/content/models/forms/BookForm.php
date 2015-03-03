<?php

namespace content\models\forms;

use content\models\Author;
use content\models\Book;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $date_created
 * @property string $date_updated
 *
 */
class BookForm extends Model
{
    /** @var  \content\models\Book */
    public $book;

    /** @var  string */
    public $title;

    /** @var  string */
    public $slug;

    /** @var  array */
    public $authors;

    /** @var  string */
    public $authorsText;

    /** @var  array */
    public $users;

    /** @var  string */
    public $usersText;

    public function __construct(Book $book, $config = [])
    {
        parent::__construct($config);
        $this->book     = $book;
        $this->title    = $book->title;
        $this->slug     = $book->slug;
        $this->authors  = ArrayHelper::map($this->book->authors, 'id', 'name');
        $this->users    = ArrayHelper::map($this->book->users, 'id', 'name');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'authorsText'], 'required'],
            [['title', 'slug'], 'string', 'max' => 150],
            [['authors', 'authorsText', 'users', 'usersText'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'         => 'Title',
            'slug'          => 'Slug',
            'authorsText'   => 'Authors',
            'usersText'     => 'Users',
        ];
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $this->authors  = array_filter(explode(',', $this->authorsText));
        $this->users    = array_filter(explode(',', $this->usersText));

        $trans = \Y::db()->beginTransaction();
        try {

            $this->book->title = $this->title;
            $this->book->slug = $this->slug;
            $this->book->save(false);

            $this->processAuthors();
            $this->processUsers();

            $trans->commit();
        } catch (Exception $e) {
            $trans->rollBack();
            return false;
        }

        return true;
    }

    protected function processAuthors()
    {
        $exists = $this->book->isNewRecord
            ? []
            : ArrayHelper::getColumn($this->book->authors, 'id');

        $removed = array_diff($exists, $this->authors);
        $added   = array_diff($this->authors, $exists);

        foreach (array_filter($removed) as $id) {
            $this->book->unlink('authors', Author::findOne($id), true);
        }
        foreach (array_filter($added) as $id) {
            $this->book->link('authors', Author::findOne($id));
        }
        $this->book->authors_count = $this->book->getAuthors()->count();
        $this->book->save(false, ['authors_count']);
    }

    protected function processUsers()
    {
        $exists = $this->book->isNewRecord
            ? []
            : ArrayHelper::getColumn($this->book->users, 'id');

        $removed = array_diff($exists, $this->users);
        $added   = array_diff($this->users, $exists);

        foreach (array_filter($removed) as $id) {
            $this->book->unlink('users', Author::findOne($id), true);
        }
        foreach (array_filter($added) as $id) {
            $this->book->link('users', Author::findOne($id));
        }
        $this->book->users_count = $this->book->getUsers()->count();
        $this->book->save(false, ['users_count']);
    }
}
