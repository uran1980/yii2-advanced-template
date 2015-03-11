## How to get request params

```php
// GET params (v.1):
$get1 = Yii::$app->request->getQueryParams();

// GET params (v.2):
$get2 = Yii::$app->getRequest()->get();

// POST params:
$post = Yii::$app->getRequest()->post();

// all request params (custom method):
$params = common\helpers\AppHelper::getRequestParams();
```


## How to get referrer

```php
$referrer = Yii::$app->getRequest()->referrer;
```