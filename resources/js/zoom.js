
const thumbImages = [...document.querySelectorAll('.indicator_thumb img')]
    .map(img => img.src);

let index = 0, scale = 1, auto = null;

const viewer = document.getElementById('fsViewer');
const fsImg = document.getElementById('fsImage');
const fullScreenBtn = document.getElementById('fullScreen');

/* 🔹 Click on MAIN slider */
document.querySelectorAll('.maxbtnset .maximized')
    .forEach((img, i) => {
        img.addEventListener('click', () => {
            index = i;
            openViewer();
        });
    });

function openViewer() {
    viewer.classList.add('active');
    scale = 1;
    showImage();
}

function closeViewer() {
    viewer.classList.remove('active');
    stopAuto();
}

function showImage() {
     scale = 1;
    fsImg.src = thumbImages[index];
    fsImg.style.transform = `scale(${scale})`;
}

/* 🔹 Slide animation helper */
function slideAnimate(direction) {
    fsImg.classList.remove('slide-left', 'slide-right');
    void fsImg.offsetWidth; // force reflow
    fsImg.classList.add(direction === 'left' ? 'slide-left' : 'slide-right');
}

/* Navigation */
document.querySelector('.fs-nav.right').onclick = () => {
    index = (index + 1) % thumbImages.length;
    slideAnimate('left');
    showImage();
};

document.querySelector('.fs-nav.left').onclick = () => {
    index = (index - 1 + thumbImages.length) % thumbImages.length;
    slideAnimate('right');
    showImage();
};

/* Zoom */
zoomIn.onclick = () => {
    scale += 0.2;
    fsImg.style.transform = `scale(${scale})`;
};

zoomOut.onclick = () => {
    scale = Math.max(1, scale - 0.2);
    fsImg.style.transform = `scale(${scale})`;
};

/* 🔹 Mouse zoom: double click */
/* 🔹 Mouse double click zoom (left = in, right = out) */
fsImg.addEventListener('mousedown', e => {
    if (e.detail !== 2) return; // double click only

    if (e.button === 0) {
        // left double click → zoom in
        scale += 0.5;
    }

    if (e.button === 2) {
        // right double click → zoom out
        scale = Math.max(1, scale - 0.5);
    }

    fsImg.style.transform = `scale(${scale})`;
});

/* Disable right click menu */
fsImg.addEventListener('contextmenu', e => e.preventDefault());


/* 🔹 Mouse wheel zoom */
fsImg.addEventListener('wheel', e => {
    e.preventDefault();
    if (e.deltaY < 0) {
        scale += 0.2;
    } else {
        scale = Math.max(1, scale - 0.2);
    }
    fsImg.style.transform = `scale(${scale})`;
}, { passive: false });

/* Auto play */
autoPlay.onclick = () => auto ? stopAuto() : startAuto();

function startAuto() {
    autoPlay.textContent = '⏸';
    auto = setInterval(() => {
        index = (index + 1) % thumbImages.length;
        slideAnimate('left');
        showImage();
    }, 2000);
}

function stopAuto() {
    autoPlay.textContent = '▶';
    clearInterval(auto);
    auto = null;
}

/* Fullscreen */


fullScreenBtn.onclick = () => {
    if (!document.fullscreenElement) {
        viewer.requestFullscreen().then(() => {
            // fullscreen on → change icon
            fullScreenBtn.textContent = '🗗';
        });
    } else {
        document.exitFullscreen().then(() => {
            // fullscreen off → revert icon
            fullScreenBtn.textContent = '⛶';
        });
    }
};

// Optional: Close button also resets icon
closeFs.onclick = () => {
    if (document.fullscreenElement) {
        document.exitFullscreen().then(() => {
            closeViewer();
            fullScreenBtn.textContent = '⛶';
        });
    } else {
        closeViewer();
        fullScreenBtn.textContent = '⛶';
    }
};


/* Keyboard */
document.addEventListener('keydown', e => {
    if (!viewer.classList.contains('active')) return;
    if (e.key === 'Escape') closeViewer();
    if (e.key === 'ArrowRight') document.querySelector('.fs-nav.right').click();
    if (e.key === 'ArrowLeft') document.querySelector('.fs-nav.left').click();
});
/* ===============================
   🔹 Drag ONLY while holding mouse
   =============================== */

let isDragging = false;
let startX = 0, startY = 0;
let offsetX = 0, offsetY = 0;

/* start drag ONLY when left button is pressed */
fsImg.addEventListener('mousedown', e => {
    if (e.button !== 0) return;   // left button only
    if (scale <= 1) return;       // only if zoomed

    isDragging = true;
    startX = e.clientX - offsetX;
    startY = e.clientY - offsetY;
});

/* move ONLY while mouse is being held */
document.addEventListener('mousemove', e => {
    if (!isDragging) return;

    offsetX = e.clientX - startX;
    offsetY = e.clientY - startY;

    fsImg.style.transform =
        `translate(${offsetX}px, ${offsetY}px) scale(${scale})`;
});

/* STOP drag immediately when mouse released */
document.addEventListener('mouseup', () => {
    isDragging = false;
});

/* reset drag position when image changes */
const _showImage = showImage;
showImage = function () {
    offsetX = 0;
    offsetY = 0;
    _showImage();
};


 document.querySelectorAll('.block__pic').forEach(img => {

    const lens = document.createElement('div');
    lens.className = 'zoom-lens';
    img.parentElement.appendChild(lens);

    const zoom = 2.5;

    img.addEventListener('mouseenter', () => {
        lens.style.display = 'block';
        lens.style.backgroundImage = `url(${img.src})`;
        lens.style.backgroundSize =
            img.width * zoom + 'px ' + img.height * zoom + 'px';
    });

    img.addEventListener('mouseleave', () => {
        lens.style.display = 'none';
    });

    img.addEventListener('mousemove', e => {
        const rect = img.getBoundingClientRect();

        // mouse position relative to image
        const cx = e.clientX - rect.left;
        const cy = e.clientY - rect.top;

        // lens center follows mouse (no clamp)
        lens.style.left = cx - lens.offsetWidth / 2 + 'px';
        lens.style.top  = cy - lens.offsetHeight / 2 + 'px';

        // background follows mouse even outside image
        const bgX = (cx * zoom) - lens.offsetWidth / 2;
        const bgY = (cy * zoom) - lens.offsetHeight / 2;

        lens.style.backgroundPosition = `-${bgX}px -${bgY}px`;
    });
});
