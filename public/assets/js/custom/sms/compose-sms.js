window.addEventListener("load", () =>
    requestAnimationFrame(() => {
        const destroyBtn = document.querySelector("#destroy");
        const reinitBtn = document.querySelector("#reinit");
        const selectEl = document.querySelector("#hs-select-temporary");
        const selectToggleIcon = document.querySelector(
            "#hs-select-temporary-toggle-icon"
        );
        const select = window.HSSelect.getInstance(selectEl);

        if (destroyBtn) {
            destroyBtn.addEventListener("click", () => {
                select.destroy();
                selectToggleIcon.style.display = "none";

                reinitBtn.removeAttribute("disabled");
                destroyBtn.setAttribute("disabled", true);
            });
        }

        if (reinitBtn) {
            reinitBtn.addEventListener("click", () => {
                new HSSelect(selectEl);
                selectToggleIcon.style.display = "";

                reinitBtn.setAttribute("disabled", true);
                destroyBtn.removeAttribute("disabled");
            });
        }
    })
);
(function () {
    ("use strict");
    const usersSelect = document.getElementById("users-select");
    const mikrotiksSelect = document.getElementById("mikrotiks-select");
    const locationsSelect = document.getElementById("locations-select");
    /* multi select with remove button */
    if (usersSelect) {
        const multipleCancelButton = new Choices("#users-select", {
            allowHTML: true,
            removeItemButton: true,
            allowSearch: true,
        });
    }
    if (mikrotiksSelect) {
        new Choices("#mikrotiks-select", {
            allowHTML: true,
            removeItemButton: true,
            allowSearch: true,
        });
    }
    if (locationsSelect) {
        new Choices("#locations-select", {
            allowHTML: true,
            removeItemButton: true,
            allowSearch: true,
        });
    }
})();
