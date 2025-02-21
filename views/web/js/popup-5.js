document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        fetch('/popup/get-config?id=5')
            .then(response => response.json())
            .then(data => {
                if(data.is_active) {
                    //Create modal logic here
                    const modal = document.getElementById('my-modal-popup');
                    if (modal) {
                       // Открыть модальное окно
                       $('#my-modal-popup').modal('show');
                    } else {
                      console.error('Элемент с id "my-modal-popup" не найден!');
                    }                     
                    incrementCounter(5);
                }
            });
    }, 10 * 1000);
});

function incrementCounter(popupId) {
    fetch('/popup/increment-counter?id=' + popupId);
}