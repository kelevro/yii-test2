<?php


namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\db\Query;


/**
 * AlertManager component
 *
 * @package common\components
 */
class AlertManager extends Component
{
    private $table = 'alert';

    /**
     * Create new alert message
     *
     * @param string $text
     * @param string|null $from
     * @param string $type
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function publish($text, $from = null, $type = 'notice')
    {
        if (empty($text)) {
            throw new InvalidParamException('Text must be non empty string');
        }

        if (!in_array($type, ['notice', 'warning'])) {
            throw new InvalidParamException("Type must be 'notice' or 'warning'");
        }

        Yii::$app->db->createCommand()->insert($this->table, array(
            'type' => $type,
            'from' => $from,
            'message' => $text,
            'is_read' => 0,
            'date_created' => new \yii\db\Expression('NOW()'),
            'date_updated' => new \yii\db\Expression('NOW()'),
        ))->execute();

        return Yii::$app->db->getLastInsertID();
    }

    /**
     * Loads all alerts by period
     *
     * @param string|null $period time period in strtotime format
     * @return array
     */
    public function getAll($period = null)
    {
        $query = new Query;
        $query->select('*')
            ->from($this->table);

        if ($period) {
            $query->andWhere('date_created <= :date', [':date' => sqldate(strtotime($period))]);
        }

        return $query->all();
    }

    /**
     * Mark alert as read
     *
     * @param int $id
     * @return bool
     */
    public function markRead($id)
    {
        \Yii::$app->db->createCommand()
            ->update($this->table, ['is_read' => 1], 'id = :id', [':id' => $id])
            ->execute();
        return true;
    }

    /**
     * Mark all alerts as read
     */
    public function markAllRead()
    {
        \Yii::$app->db->createCommand()
            ->update($this->table, ['is_read' => 1], '1 = 1')
            ->execute();
        return true;
    }
}