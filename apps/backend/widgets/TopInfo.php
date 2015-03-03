<?php


namespace backend\widgets;

use yii\base\Widget;

/**
 * Top info widget at index page
 *
 * @package backend\widgets
 */
class TopInfo extends Widget
{
    public function run()
    {
        $totalArticles = \Yii::$app->db->createCommand("
            SELECT COUNT(*)
            FROM content_article AS ca
            WHERE ca.is_published = 1
            AND ca.project_id = :pid
        ", [':pid' => \Y::projectId()])->queryScalar();

        $thisMonthArticle = \Yii::$app->db->createCommand("
            SELECT COUNT(*)
            FROM content_article AS ca
            WHERE ca.is_published = 1
            AND ca.project_id = :pid
            AND ca.date_created >= :date
        ", [
            ':pid' => \Y::projectId(),
            ':date' => date('Y-m-01 00:00:00'),
        ])->queryScalar();

        echo $this->render('top-info', [
            'totalArticles'    => $totalArticles,
            'thisMonthArticle' => $thisMonthArticle,
        ]);
    }
}