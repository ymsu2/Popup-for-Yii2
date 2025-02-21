<?php

use app\models\Popup;

$popupData = Popup::findOne(5);

if ($popupData) { // Автоматически проверяет на null
    $title = $popupData->title;
    $content = $popupData->content;
    $width = $popupData->width;
    $height = $popupData->height;
} else {
    $title = "Запись не найдена!";
    $content = $width = $height = '';
}

use \yii\bootstrap5\Modal;
Modal::begin([
	'id' =>'my-modal-popup',
	'closeButton' => ['tag' => 'button'],
	'title' => $title,
]);
echo '<div style="font-size: 22px; background-color: #000000; color: #ffffff; width: '.$width.'px; height: '.$height.'px; margin: 0 auto; display: flex; justify-content: center; text-align: center;">'.$content.'</div>';
echo '<div>&nbsp;</div>';
echo '<div class="col-md-12 text-center">
      <form id="close_popup">
      <button type="button" onclick="$(\'#my-modal-popup\').modal(\'hide\');" class="btn btn-success px-5 fw-bold">Закрыть окно</button>
      </form>
      </div>';
Modal::end();

?>
</br></br></br></br>
    <script>
        var popupData = <?= json_encode($popupData) ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/web/js/popup-<?= $popupId ?>.js"></script>

    <h2 align="center"> <?= $title ?></h2>



