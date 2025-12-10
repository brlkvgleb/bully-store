import './bootstrap';

const input = document.getElementById('imageInput');
const preview = document.getElementById('preview');

input.addEventListener('change', function() {
    preview.innerHTML = ''; // очищаем предыдущие превью

    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('preview-img');
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});
