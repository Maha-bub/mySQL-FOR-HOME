// =============================================
//  main.js — JavaScript Helpers
// =============================================

// Confirm before deleting a product
function confirmDelete(id, name) {
    if (confirm("⚠️ Delete \"" + name + "\"?\n\nThis cannot be undone.")) {
        window.location.href = "delete.php?id=" + id;
    }
}

// Auto-hide alerts after 4 seconds
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

    // Preview image before uploading
    const imageInput = document.getElementById("image");
    if (imageInput) {
        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    let preview = document.getElementById("img-preview");
                    if (!preview) {
                        preview = document.createElement("img");
                        preview.id = "img-preview";
                        preview.style.cssText = "width:80px;height:80px;object-fit:cover;border-radius:10px;margin-top:10px;border:1px solid #2a2a3a;display:block;";
                        imageInput.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
