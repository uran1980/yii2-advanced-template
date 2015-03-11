## How to debug sql queries

```php
\common\helpers\AppDebug::dump(array(
    'sql' => (new \yii\db\mysql\QueryBuilder(Yii::$app->db))->build($query),
));
```