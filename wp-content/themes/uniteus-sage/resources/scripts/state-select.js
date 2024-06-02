document.addEventListener('DOMContentLoaded', initFormSelectState, false)

function initFormSelectState() {
  document.addEventListener('change', function(e) {
    const formSelect = document.querySelector("select");
    let isBinded = false;
    if (formSelect === e.target) {
      if (!isBinded) {
        formSelect.addEventListener('change', function() {
          initFormSelectState();
          isBinded = true;
        });
        formSelect.classList.add('selected');
      }
      formSelect.classList.add('selected');
    }
  });
}
