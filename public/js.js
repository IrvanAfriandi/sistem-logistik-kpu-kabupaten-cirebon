function adjustFontSize(element) {
    const parentWidth = element.parentElement.offsetWidth;
    const elementWidth = element.offsetWidth;

    if (elementWidth > parentWidth) {
        const scale = parentWidth / elementWidth;
        element.style.transform = `scale(${scale})`;
    } else {
        element.style.transform = 'scale(1)';
    }
}

// Pilih elemen teks
const textElement = document.querySelector('.text-shrink');
adjustFontSize(textElement);

// Atur ulang saat window di-resize
window.addEventListener('resize', () => adjustFontSize(textElement));
