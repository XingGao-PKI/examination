<?php
/**
 * file: ChapterController.php
 * desc: 章节信息 执行操作控制器
 * date: 2016-10-11 15:47:39
 */

namespace app\modules\admin\controllers;

use app\common\models\CarType;
use app\common\models\Chapter;
use app\common\models\Subject;

class ChapterController extends Controller
{
    /**
     * where() 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'id' => '=',
			'name' => 'like',
            'subject_id' => '='
        ];
    }

    public function actionIndex()
    {
        $subject = Subject::getSubject();
        return $this->render('index', [
            'subject' => $subject,
        ]);
    }


    /**
     * getModel() 返回model
     * @return Chapter
     */
    public function getModel()
    {
        return new Chapter();
    }
}
