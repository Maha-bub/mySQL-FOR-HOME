// =============================================
//  main.js — Sidebar + UI helpers
// =============================================

/* ── SIDEBAR TOGGLE (mobile) ── */
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── DELETE CONFIRM ── */
function confirmDelete(id, name) {
    if (confirm('⚠️ Delete "' + name + '"?\n\nThis action cannot be undone.')) {
        window.location.href = 'delete.php?id=' + id;
    }
}

/* ── AUTO-HIDE ALERTS ── */
document.addEventListener('DOMContentLoaded', function () {

    // Auto-dismiss alerts after 4 seconds
    document.querySelectorAll('.alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity    = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 4000);
    });

    // ── IMAGE UPLOAD PREVIEW ──
    const fileInput = document.getElementById('image-upload');
    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                let preview = document.getElementById('img-preview');
                const box   = document.getElementById('img-preview-box');

                if (!preview) {
                    preview    = document.createElement('img');
                    preview.id = 'img-preview';
                }
                preview.src = e.target.result;

                if (box) {
                    box.style.display = 'flex';
                    const existing    = box.querySelector('img');
                    if (existing) existing.src = e.target.result;
                    else box.prepend(preview);
                }

                // Update label text
                const label = document.querySelector('.file-input-text');
                if (label) label.innerHTML = '<strong>' + file.name + '</strong>';
            };
            reader.readAsDataURL(file);
        });

        // Clicking the wrapper triggers file picker
        const wrapper = document.querySelector('.file-input-wrapper');
        if (wrapper) {
            wrapper.addEventListener('click', function () {
                fileInput.click();
            });
        }
    }
});
