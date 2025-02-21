<?php

$(document).ready(function() {
    setTimeout(function() {
        $.ajax({
            url: '/popup/get-config',
            data: {id: <?= $model->id ?>},
            success: function(response) {
                if(response.is_active) {
                    showPopup(response);
                }
            }
        });
    }, <?= $model->show_after * 1000 ?>);
});

function showPopup(config) {
    const modal = $(`
        <div class="modal fade" id="popupModal">
            <div class="modal-dialog" style="width:${config.width}px; height:${config.height}px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>${config.title}</h4>
                    </div>
                    <div class="modal-body">
                        ${config.content}
                        <button type="button" class="close-popup btn btn-default">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `);

    modal.find('.close-popup').click(function() {
        modal.modal('hide');
    });

    $('body').append(modal);
    modal.modal('show').on('hidden.bs.modal', function() {
        modal.remove();
    });
    
    // Анимация появления
    modal.find('.modal-dialog')
        .css('transform', 'scale(0)')
        .animate({transform: 'scale(1)'}, 500);
}