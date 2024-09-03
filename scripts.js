document.getElementById('taxToggle').addEventListener('change', function () {
    if (this.checked) {
        alert('Tax included in the total price');
    } else {
        alert('Tax not included in the total price');
    }
});
