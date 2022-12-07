const body = document.querySelector("body");
const deleteButtons = document.querySelectorAll(".admin-button.delete");
const darkOverlays = document.querySelectorAll(".dark-overlay");
const cancelButtons = document.querySelectorAll(".button.cancel");

// Display popup onclick on trash buttons
for (const deleteButton of deleteButtons) {
  const deleteButtonChildren = deleteButton.children;
  const clickableElements = [deleteButton, deleteButtonChildren];
  for (const clickableElement of clickableElements) {
    clickableElement.onclick = (event) => {
      let buttonId = event.target.id;
      let regex = /\D/g;
      buttonId = buttonId.replace(regex, "");

      for (const darkOverlay of darkOverlays) {
        let darkOverlayId = darkOverlay.id.replace(regex, "");

        if (darkOverlayId === buttonId) {
          darkOverlay.classList.add("active");
          body.style.overflow = "hidden";
        }
      }
    };
  }
}

// Close popup onclick on cancel button
if (cancelButtons) {
  for (const cancelButton of cancelButtons) {
    cancelButton.onclick = () => {
      for (const darkOverlay of darkOverlays) {
        if (darkOverlay.classList.contains("active")) {
          darkOverlay.classList.remove("active");
          body.style.overflow = "auto";
        }
      }
    };
  }
}

// Close popup onclick on dark overlay
window.addEventListener("click", (event) => {
  for (const darkOverlay of darkOverlays) {
    if (event.target == darkOverlay) {
      darkOverlay.classList.remove("active");
      body.style.overflow = "auto";
    }
  }
});
